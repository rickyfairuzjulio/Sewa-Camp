<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        Paginator::useBootstrapFive();

        RateLimiter::for('login', function (Request $request): Limit {
            $key = Str::lower($request->string('email')->trim()->toString()).'|'.$request->ip();

            return Limit::perMinute(5)->by(hash('sha256', $key));
        });

        RateLimiter::for('registration', function (Request $request): Limit {
            return Limit::perMinute(3)->by($request->ip());
        });
    }
}
