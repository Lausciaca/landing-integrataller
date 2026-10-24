<?php

namespace App\Support;

/**
 * Links to the SaaS (config `landing.saas_url`). The self-service signup
 * starts with the Google login, which then continues to /registro.
 */
final class Saas
{
    public static function signupUrl(): string
    {
        return config('landing.saas_url').'/auth/google/redirect';
    }

    public static function loginUrl(): string
    {
        return config('landing.saas_url').'/login';
    }
}
