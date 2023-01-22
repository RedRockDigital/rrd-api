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
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $url = request()->filled('url') ? request()->get('url') : config('app.url').'verify/';
            $token = hash_hmac('sha256', $notifiable->getKey(), sha1($notifiable->getEmailForVerification()));

            return $url.$notifiable->getKey().'/'.$token;
        });

        View::composer('app', function ($view) {
            $view->with('app', [
                'groups'        => Group::all(),
                'feature_flags' => config('feature-flags'),
                'tiers'         => config('payments.stripe.tiers'),
            ]);
        });
    }
}
