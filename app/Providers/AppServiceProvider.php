<?php

namespace App\Providers;

use App\Services\PlanesPublicos;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // One lookup per request: the home, the header and the JSON-LD share it.
        $this->app->scoped(PlanesPublicos::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Own counter: the plain "throttle:X,1" middleware shares one counter
        // per IP across routes, so browsing beacons would use up the forms' limit.
        RateLimiter::for('analytics', fn (Request $request) => Limit::perMinute(120)->by('analytics|'.$request->ip()));
    }
}
