<?php

namespace App\Http\Controllers;

use App\Mail\DemoRequestNotification;
use App\Models\Contact;
use App\Services\AnalyticsRecorder;
use App\Services\MetaConversions;
use App\Services\NewsletterSubscriptionService;
use App\Services\SaasNotifier;
use App\Support\Attribution;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class ContactController extends Controller
{
    /**
     * Store a demo request submitted from the landing page.
     */
    public function store(
        Request $request,
        NewsletterSubscriptionService $newsletter,
        SaasNotifier $saas,
        AnalyticsRecorder $analytics,
        MetaConversions $meta
    ): RedirectResponse|JsonResponse {
        if ($request->filled('website')) {
            return $this->done($request);
        }

        // Short form: name, WhatsApp and number of branches. The rest is optional.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^(?:\D*\d){8,}\D*$/'],
            'branches' => ['required', Rule::in(array_keys(Contact::BRANCHES))],
            'taller' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email:rfc', 'max:254'],
            'message' => ['nullable', 'string', 'max:2000'],
            'marketing_opt_in' => ['nullable', 'boolean'],
            'attribution' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.required' => 'Escribí tu nombre.',
            'phone.required' => 'Escribí tu WhatsApp.',
            'phone.regex' => 'Revisá el número: incluí el código de área.',
            'branches.required' => 'Elegí cuántas sucursales tiene tu taller.',
            'branches.in' => 'Elegí cuántas sucursales tiene tu taller.',
            'email.email' => 'Revisá el email.',
            'max' => 'Es demasiado largo.',
        ]);

        $email = filled($validated['email'] ?? null) ? Str::lower(trim($validated['email'])) : null;
        $marketingOptIn = $email && ($validated['marketing_opt_in'] ?? false);
        $branches = 'Sucursales: '.Contact::BRANCHES[$validated['branches']];
        $attribution = Attribution::fromJson($validated['attribution'] ?? null);
        $eventId = (string) Str::uuid();
        $contact = Contact::create([
            ...array_diff_key($attribution, ['fbclid' => true]),
            'meta_event_id' => $eventId,
            'name' => $validated['name'],
            'taller' => $validated['taller'] ?? null,
            'branches' => $validated['branches'],
            'phone' => $validated['phone'],
            'email' => $email,
            // The admin app reads the message, so the branches also travel there.
            'message' => filled($validated['message'] ?? null) ? $branches."\n\n".$validated['message'] : $branches,
            'marketing_opt_in_requested' => $marketingOptIn,
            'source' => 'demo-form',
        ]);
        $saas->notify('demo-request.created', $contact->id);
        $analytics->record($request, 'demo_submit', $attribution, ['path' => '/contacto']);
        $meta->send($request, 'Lead', $eventId, route('contacto'), [
            'email' => $email,
            'phone' => $contact->phone,
            'name' => $contact->name,
            'fbclid' => $attribution['fbclid'],
        ]);

        $notificationEmail = config('landing.demo_notification_email');
        if (is_string($notificationEmail) && $notificationEmail !== '') {
            try {
                Mail::to($notificationEmail)->send(new DemoRequestNotification($contact));
            } catch (Throwable $exception) {
                Log::error('Could not send demo request notification.', [
                    'contact_id' => $contact->id,
                    'exception' => $exception::class,
                ]);
            }
        }

        $subscriptionResult = null;
        if ($marketingOptIn) {
            $subscriptionResult = $newsletter->requestConfirmation($email, 'demo-form');
        }

        session()->flash('newsletter_result', $subscriptionResult);
        session()->flash('conversion', ['meta' => 'Lead', 'ga' => 'generate_lead', 'id' => $eventId]);

        return $this->done($request);
    }

    /** The dialog sends the form with fetch and navigates itself; without JS it is a normal redirect. */
    private function done(Request $request): RedirectResponse|JsonResponse
    {
        return $request->expectsJson()
            ? response()->json(['redirect' => route('demo.thank-you')])
            : redirect()->route('demo.thank-you');
    }
}
