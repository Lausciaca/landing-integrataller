<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Cookie consent chosen in the banner. The browser stores it in the
 * first-party `it_consent` cookie as `v<version>.a<0|1>.m<0|1>`
 * (a = analytics, m = marketing/advertising).
 */
final class Consent
{
    public const COOKIE = 'it_consent';

    private function __construct(public readonly bool $analytics, public readonly bool $marketing) {}

    public static function fromRequest(Request $request): self
    {
        $value = (string) $request->cookie(self::COOKIE, '');
        $version = (int) config('landing.cookie_consent_version', 1);

        if (! preg_match('/^v(\d+)\.a([01])\.m([01])$/', $value, $match) || (int) $match[1] !== $version) {
            return new self(false, false);
        }

        return new self($match[2] === '1', $match[3] === '1');
    }
}
