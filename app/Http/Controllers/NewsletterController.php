<?php

namespace App\Http\Controllers;

use App\Services\NewsletterSubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function store(Request $request, NewsletterSubscriptionService $subscriptions): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect()->route('newsletter.pending')->with('newsletter_result', 'confirmation_sent');
        }

        $validated = $request->validate([
            'subscription_email' => ['required', 'email:rfc', 'max:254'],
            'subscription_source' => ['required', 'string', 'in:home,servicios,guias,footer,popup'],
        ]);

        $result = $subscriptions->requestConfirmation(
            Str::lower(trim($validated['subscription_email'])),
            $validated['subscription_source']
        );

        return redirect()->route('newsletter.pending')->with('newsletter_result', $result);
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
