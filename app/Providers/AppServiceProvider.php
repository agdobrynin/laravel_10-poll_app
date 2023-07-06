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
            function (Application $application) {
                return new RateLimiter(
                    $application->make(\Illuminate\Cache\RateLimiter::class),
                    $application->make(\Illuminate\Http\Request::class)
                );
            }
        );
    }
}
