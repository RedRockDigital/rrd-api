<?php

namespace RedRockDigital\Api\Providers;

use RedRockDigital\Api\Models\Group;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        
    }
}
