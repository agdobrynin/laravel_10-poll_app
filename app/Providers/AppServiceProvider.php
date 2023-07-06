<?php

namespace App\Providers;

use App\Contracts\RateLimiterInterface;
use App\Services\RateLimiter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            RateLimiterInterface::class,
            fn(Application $app) => $app->make(RateLimiter::class)
        );
    }
}
