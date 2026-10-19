<?php

namespace App\Support;

/**
 * Session attribution sent by the browser (sessionStorage `it_attr`): where
 * the visit came from. Everything is sanitized and size-limited here.
 */
final class Attribution
{
    public static function fromJson(?string $json): array
    {
        $data = json_decode((string) $json, true);

        return self::sanitize(is_array($data) ? $data : []);
    }

    public static function sanitize(array $data): array
    {
        $text = fn (string $key, int $max = 150) => is_string($data[$key] ?? null) && trim($data[$key]) !== ''
            ? mb_substr(trim($data[$key]), 0, $max)
            : null;

        $session = $text('session_id', 64);
        $landing = $text('landing_page', 255);

        return [
            'session_id' => $session && preg_match('/^[A-Za-z0-9-]{8,64}$/', $session) ? $session : null,
            'landing_page' => $landing && str_starts_with($landing, '/') ? $landing : null,
            'referrer_host' => self::host($text('referrer', 500)),
            'utm_source' => $text('utm_source'),
            'utm_medium' => $text('utm_medium'),
            'utm_campaign' => $text('utm_campaign'),
            'utm_content' => $text('utm_content'),
            'utm_term' => $text('utm_term'),
            'click_id' => in_array($data['click_id'] ?? null, ['fbclid', 'gclid'], true) ? $data['click_id'] : null,
            'fbclid' => $text('fbclid', 500),
        ];
    }

    /** External referrer host, without "www."; null for our own domain. */
    private static function host(?string $referrer): ?string
    {
        $host = $referrer ? parse_url(str_contains($referrer, '://') ? $referrer : 'https://'.$referrer, PHP_URL_HOST) : null;
        if (! is_string($host) || $host === '') {
            return null;
        }
        $host = mb_strtolower(preg_replace('/^www\./i', '', $host));
        $own = preg_replace('/^www\./i', '', (string) parse_url((string) config('app.url'), PHP_URL_HOST));

        return $host === mb_strtolower($own) || $host === mb_strtolower(preg_replace('/^www\./i', '', request()->getHost())) ? null : mb_substr($host, 0, 150);
    }
}
