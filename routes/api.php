<?php

use App\Http\Controllers\Api\LandingDataController;
use App\Http\Middleware\AuthenticateLandingApi;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/landing')
    ->middleware([AuthenticateLandingApi::class, 'throttle:60,1'])
    ->name('api.landing.')
    ->group(function (): void {
        Route::get('/demo-requests', [LandingDataController::class, 'demoRequests'])->name('demo-requests');
        Route::get('/newsletter-subscribers', [LandingDataController::class, 'newsletterSubscribers'])->name('newsletter-subscribers');
        Route::put('/newsletter-subscribers/{subscriberId}/unsubscribe', [LandingDataController::class, 'unsubscribe'])
            ->whereNumber('subscriberId')
            ->name('newsletter-subscribers.unsubscribe');
    });
