<?php

namespace App\Providers;

use App\Models\Vizilenyek;
use App\Observers\ViziLenyekObserver;
use Illuminate\Auth\Notifications\ResetPassword;
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
        Vizilenyek::observe(ViziLenyekObserver::class);
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset?token={$token}&email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
