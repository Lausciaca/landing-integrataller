<?php

namespace App\Support;

/**
 * Argentine phone numbers as typed in the demo form ("0336 15 400-6452").
 */
final class Telefono
{
    /** E.164 digits (54 9 + area + number) when it can be inferred; otherwise the digits as typed. */
    public static function e164(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '' || strlen($digits) < 8) {
            return null;
        }
        if (str_starts_with($digits, '54')) {
            return $digits;
        }
        $digits = ltrim($digits, '0');
        $digits = preg_replace('/^(\d{2,4})15(\d{6,8})$/', '$1$2', $digits) ?? $digits;

        return strlen($digits) === 10 ? '549'.$digits : $digits;
    }
}
