<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Written by JavaScript (consent banner and Meta Pixel), read as plain text.
        $middleware->encryptCookies(except: ['it_consent', '_fbp', '_fbc']);
        // Public lead form without login (honeypot + throttle). The Facebook and
        // Instagram in-app browsers prefetch pages, which leaves a CSRF token that
        // no longer matches the session and ends in a 419 on submit.
        $middleware->validateCsrfTokens(except: ['contacto']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
