<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsRecorder;
use App\Services\MetaConversions;
use App\Services\NewsletterSubscriptionService;
use App\Support\Attribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function store(
        Request $request,
        NewsletterSubscriptionService $subscriptions,
        AnalyticsRecorder $analytics,
        MetaConversions $meta
    ): RedirectResponse {
        if ($request->filled('website')) {
            return redirect()->route('newsletter.pending')->with('newsletter_result', 'confirmation_sent');
        }

        $validated = $request->validate([
            'subscription_email' => ['required', 'email:rfc', 'max:254'],
            'subscription_source' => ['required', 'string', 'in:home,servicios,guias,footer'],
            'attribution' => ['nullable', 'string', 'max:2000'],
        ]);

        $email = Str::lower(trim($validated['subscription_email']));
        $result = $subscriptions->requestConfirmation($email, $validated['subscription_source']);

        $redirect = redirect()->route('newsletter.pending')->with('newsletter_result', $result);
        if ($result !== 'confirmation_sent') {
            return $redirect;
        }

        $attribution = Attribution::fromJson($validated['attribution'] ?? null);
        $eventId = (string) Str::uuid();
        $analytics->record($request, 'newsletter_submit', $attribution, [
            'path' => parse_url(url()->previous(), PHP_URL_PATH) ?: '/',
            'label' => $validated['subscription_source'],
        ]);
        $meta->send($request, 'CompleteRegistration', $eventId, url()->previous(), [
            'email' => $email,
            'fbclid' => $attribution['fbclid'],
        ]);

        return $redirect->with('conversion', ['meta' => 'CompleteRegistration', 'ga' => 'sign_up', 'id' => $eventId]);
    }

    public function pending(): View
    {
        return view('newsletter.pending');
    }

    public function confirmForm(string $token, NewsletterSubscriptionService $subscriptions): View
    {
        return view('newsletter.confirm', [
            'valid' => $subscriptions->pendingSubscriber($token) !== null,
            'token' => $token,
        ]);
    }

    public function confirm(Request $request, NewsletterSubscriptionService $subscriptions): View
    {
        $validated = $request->validate(['confirmation_token' => ['required', 'string', 'size:64']]);
        $subscriber = $subscriptions->confirm($validated['confirmation_token']);

        return view('newsletter.confirmed', ['confirmed' => $subscriber !== null]);
    }

    public function unsubscribeForm(string $token, NewsletterSubscriptionService $subscriptions): View
    {
        return view('newsletter.unsubscribe', [
            'valid' => $subscriptions->activeSubscriberForUnsubscribe($token) !== null,
            'token' => $token,
        ]);
    }

    public function unsubscribe(Request $request, NewsletterSubscriptionService $subscriptions): View
    {
        $validated = $request->validate(['unsubscribe_token' => ['required', 'string', 'size:64']]);
        $subscriber = $subscriptions->unsubscribe($validated['unsubscribe_token']);

        return view('newsletter.unsubscribed', ['unsubscribed' => $subscriber !== null]);
    }
}
