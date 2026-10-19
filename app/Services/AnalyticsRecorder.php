<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Support\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use function Illuminate\Support\defer;

/**
 * Stores first-party analytics events. Anonymous by design: the IP address
 * is only used, together with the user agent and a salt that rotates every
 * day, to count unique visitors; it is never stored.
 */
class AnalyticsRecorder
{
    public function record(Request $request, string $type, array $attribution, array $extra = []): ?AnalyticsEvent
    {
        $ua = $request->userAgent();
        if (UserAgent::isBot($ua)) {
            return null;
        }

        $event = AnalyticsEvent::create([
            'occurred_at' => now(),
            'session_id' => $attribution['session_id'] ?? (string) Str::uuid(),
            'visitor_hash' => $this->visitorHash($request),
            'type' => $type,
            'path' => mb_substr($extra['path'] ?? '/'.ltrim($request->path(), '/'), 0, 255),
            'device' => UserAgent::device($ua, $extra['width'] ?? null),
            'browser' => UserAgent::browser($ua),
            'os' => UserAgent::os($ua),
            'label' => isset($extra['label']) ? mb_substr((string) $extra['label'], 0, 150) : null,
            'value' => $extra['value'] ?? null,
            ...array_intersect_key($attribution, array_flip(AnalyticsEvent::ATTRIBUTION)),
        ]);

        if (random_int(1, 500) === 1) {
            $days = (int) config('landing.analytics.retention_days', 90);
            defer(fn () => AnalyticsEvent::where('occurred_at', '<', now()->subDays($days))->delete());
        }

        return $event;
    }

    private function visitorHash(Request $request): string
    {
        $salt = Cache::remember('analytics-salt:'.now()->toDateString(), now()->addDays(2), fn () => Str::random(40));

        return substr(hash('sha256', $salt.'|'.$request->ip().'|'.$request->userAgent()), 0, 16);
    }
}
