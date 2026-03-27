<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
           return Limit::perMinute(100)->by(
               $request->user()?->id ?: $request->ip()
            );
        });

        RateLimiter::for('api', function (Request $request) {
             return Limit::perMinute(3)
             ->by($request->ip())
             ->response(function () {
                 return response()->json([
                           'message' => 'Too many requests'
                 ], 429);
             });
        });

    }
}
