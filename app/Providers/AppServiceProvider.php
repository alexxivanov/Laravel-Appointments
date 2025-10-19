<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Notifications\NotificationManager;
use App\Services\Notifications\SmsChannel;
use App\Services\Notifications\EmailChannel;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NotificationManager::class, function ($app) {
            // Set different notification channels
            return new NotificationManager([
                $app->make(SmsChannel::class),
                $app->make(EmailChannel::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
