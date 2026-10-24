<?php

namespace App\Services;

use App\Support\Consent;
use App\Support\Telefono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

use function Illuminate\Support\defer;

/**
 * Meta Conversions API: the same conversion the browser pixel reports, sent
 * from the server with the same event_id so Meta deduplicates them. It only
 * runs when the visitor accepted advertising cookies.
 */
class MetaConversions
{
    public function enabled(Request $request): bool
    {
        return filled(config('landing.analytics.meta_pixel_id'))
            && filled(config('landing.analytics.meta_capi_token'))
            && Consent::fromRequest($request)->marketing;
    }

    /**
     * @param  array{email?: ?string, phone?: ?string, name?: ?string, fbclid?: ?string}  $person
     */
    public function send(Request $request, string $eventName, string $eventId, string $sourceUrl, array $person = []): void
    {
        if (! $this->enabled($request)) {
            return;
        }

        $event = [
            'event_name' => $eventName,
            'event_time' => now()->getTimestamp(),
            'event_id' => $eventId,
            'action_source' => 'website',
            'event_source_url' => $sourceUrl,
            'user_data' => array_filter([
                'em' => $this->hashed(Str::lower(trim((string) ($person['email'] ?? '')))),
                'ph' => $this->hashed(Telefono::e164($person['phone'] ?? null)),
                'fn' => $this->hashed(Str::lower(Str::before(trim((string) ($person['name'] ?? '')), ' '))),
                'client_ip_address' => $request->ip(),
                'client_user_agent' => $request->userAgent(),
                'fbp' => $request->cookie('_fbp'),
                'fbc' => $request->cookie('_fbc') ?: $this->fbc($person['fbclid'] ?? null),
            ]),
        ];

        $payload = array_filter([
            'data' => [$event],
            'test_event_code' => config('landing.analytics.meta_test_event_code'),
        ]);
        $url = sprintf(
            'https://graph.facebook.com/%s/%s/events',
            config('landing.analytics.meta_graph_version'),
            config('landing.analytics.meta_pixel_id'),
        );
        $token = (string) config('landing.analytics.meta_capi_token');

        defer(function () use ($url, $token, $payload, $eventName): void {
            try {
                $response = Http::asJson()->connectTimeout(3)->timeout(8)
                    ->post($url.'?access_token='.urlencode($token), $payload);

                if (! $response->successful()) {
                    Log::warning('Meta Conversions API rejected an event.', [
                        'event' => $eventName,
                        'status' => $response->status(),
                        'error' => $response->json('error.message'),
                    ]);
                }
            } catch (Throwable $exception) {
                Log::warning('Could not reach the Meta Conversions API.', [
                    'event' => $eventName,
                    'exception' => $exception::class,
                ]);
            }
        });
    }

    /** @return list<string>|null */
    private function hashed(?string $value): ?array
    {
        return $value ? [hash('sha256', $value)] : null;
    }

    private function fbc(?string $fbclid): ?string
    {
        return $fbclid ? 'fb.1.'.now()->getTimestampMs().'.'.$fbclid : null;
    }
}
