<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\LogUserRegistration;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        Event::listen(
            UserRegistered::class,
            LogUserRegistration::class,
        );
    }
}
