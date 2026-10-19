<?php

namespace App\Support;

/** Minimal user-agent parsing: enough for device, browser and OS reports. */
final class UserAgent
{
    private const BOTS = '/bot|crawl|spider|slurp|facebookexternalhit|meta-externalagent|whatsapp|telegram|preview|headless|lighthouse|pagespeed|pingdom|uptime|monitor|curl|wget|python|axios|httpclient|java\/|go-http|okhttp|scrapy/i';

    public static function isBot(?string $ua): bool
    {
        return $ua === null || trim($ua) === '' || preg_match(self::BOTS, $ua) === 1;
    }

    public static function device(?string $ua, ?int $width = null): string
    {
        $ua = (string) $ua;
        if (preg_match('/iPad|Tablet|PlayBook|Silk|(Android(?!.*Mobile))/i', $ua)) {
            return 'tablet';
        }
        if (preg_match('/Mobi|iPhone|iPod|Android.*Mobile|Windows Phone/i', $ua)) {
            return 'mobile';
        }
        if ($width !== null && $width > 0 && $width < 768) {
            return 'mobile';
        }

        return 'desktop';
    }

    public static function browser(?string $ua): ?string
    {
        $ua = (string) $ua;

        return match (true) {
            (bool) preg_match('/Instagram/i', $ua) => 'Instagram',
            (bool) preg_match('/FBAN|FBAV|FB_IAB/i', $ua) => 'Facebook',
            (bool) preg_match('/Edg\//', $ua) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/', $ua) => 'Opera',
            (bool) preg_match('/SamsungBrowser/', $ua) => 'Samsung Internet',
            (bool) preg_match('/Firefox|FxiOS/', $ua) => 'Firefox',
            (bool) preg_match('/Chrome|CriOS/', $ua) => 'Chrome',
            (bool) preg_match('/Safari/', $ua) => 'Safari',
            default => null,
        };
    }

    public static function os(?string $ua): ?string
    {
        $ua = (string) $ua;

        return match (true) {
            (bool) preg_match('/iPhone|iPad|iPod/', $ua) => 'iOS',
            (bool) preg_match('/Android/', $ua) => 'Android',
            (bool) preg_match('/Windows/', $ua) => 'Windows',
            (bool) preg_match('/Mac OS X|Macintosh/', $ua) => 'macOS',
            (bool) preg_match('/CrOS/', $ua) => 'ChromeOS',
            (bool) preg_match('/Linux/', $ua) => 'Linux',
            default => null,
        };
    }
}
