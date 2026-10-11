<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateLandingApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = config('services.integrataller.api_token');

        if (! is_string($expectedToken) || $expectedToken === '') {
            return response()->json(['message' => 'Landing API is not configured.'], 503)
                ->header('Cache-Control', 'no-store');
        }

        $providedToken = $request->bearerToken();

        if (! is_string($providedToken) || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Unauthenticated.'], 401)
                ->header('Cache-Control', 'no-store');
        }

        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, no-store');

        return $response;
    }
}
