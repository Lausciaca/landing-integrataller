<?php

namespace App\Http\Controllers;

use App\Mail\DemoRequestNotification;
use App\Models\Contact;
use App\Services\NewsletterSubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ContactController extends Controller
{
    /**
     * Store a demo request submitted from the landing page.
     */
    public function store(
        Request $request,
        NewsletterSubscriptionService $newsletter
    ): RedirectResponse {
        if ($request->filled('website')) {
            return redirect()->route('demo.thank-you');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'taller' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'message' => ['nullable', 'string', 'max:2000'],
            'marketing_opt_in' => ['nullable', 'boolean'],
        ]);

        $email = Str::lower(trim($validated['email']));
        $marketingOptIn = (bool) ($validated['marketing_opt_in'] ?? false);
        $contact = Contact::create([
            'name' => $validated['name'],
            'taller' => $validated['taller'],
            'phone' => $validated['phone'],
            'email' => $email,
            'message' => $validated['message'] ?? '',
            'marketing_opt_in_requested' => $marketingOptIn,
            'source' => 'demo-form',
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

        return redirect()->route('demo.thank-you')->with('newsletter_result', $subscriptionResult);
    }
}
