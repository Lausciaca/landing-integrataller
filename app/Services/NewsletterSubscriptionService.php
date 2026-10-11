<?php

namespace App\Services;

use App\Mail\ConfirmNewsletterSubscription;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class NewsletterSubscriptionService
{
    public function requestConfirmation(string $email, string $source): string
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber?->isActive()) {
            return 'already_subscribed';
        }

        $token = Str::random(64);
        $subscriber ??= new NewsletterSubscriber(['email' => $email]);
        $subscriber->fill([
            'status' => 'pending',
            'confirmation_token_hash' => hash('sha256', $token),
            'confirmation_expires_at' => now()->addDay(),
            'unsubscribe_token_hash' => null,
            'source' => $source,
            'consent_version' => config('landing.marketing_consent_version'),
            'consented_at' => now(),
            'confirmed_at' => null,
            'unsubscribed_at' => null,
        ]);
        $subscriber->save();

        try {
            Mail::to($email)->send(new ConfirmNewsletterSubscription(
                route('newsletter.confirm.show', ['token' => $token])
            ));
        } catch (Throwable $exception) {
            Log::error('Could not send newsletter confirmation email.', [
                'subscriber_id' => $subscriber->id,
                'exception' => $exception::class,
            ]);

            return 'email_failed';
        }

        return 'confirmation_sent';
    }

    public function pendingSubscriber(string $token): ?NewsletterSubscriber
    {
        return NewsletterSubscriber::query()
            ->where('status', 'pending')
            ->where('confirmation_expires_at', '>', now())
            ->where('confirmation_token_hash', hash('sha256', $token))
            ->first();
    }

    public function activeSubscriberForUnsubscribe(string $token): ?NewsletterSubscriber
    {
        return NewsletterSubscriber::query()
            ->where('status', 'active')
            ->where('unsubscribe_token_hash', hash('sha256', $token))
            ->first();
    }

    public function confirm(string $token): ?NewsletterSubscriber
    {
        $subscriber = $this->pendingSubscriber($token);
        if (! $subscriber) {
            return null;
        }

        $unsubscribeToken = Str::random(64);
        $subscriber->fill([
            'status' => 'active',
            'confirmation_token_hash' => null,
            'confirmation_expires_at' => null,
            'unsubscribe_token_hash' => hash('sha256', $unsubscribeToken),
            'confirmed_at' => now(),
        ])->save();

        return $subscriber;
    }

    public function unsubscribe(string $token): ?NewsletterSubscriber
    {
        $subscriber = $this->activeSubscriberForUnsubscribe($token);

        if (! $subscriber) {
            return null;
        }

        $subscriber->fill([
            'status' => 'unsubscribed',
            'unsubscribe_token_hash' => null,
            'unsubscribed_at' => now(),
        ])->save();

        return $subscriber;
    }
}
