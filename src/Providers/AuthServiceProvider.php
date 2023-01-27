<?php

namespace RedRockDigital\Api\Providers;

use RedRockDigital\Api\Models\Token;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes(null, [
                'prefix' => 'api/oauth',
            ]);
        }

        Passport::tokensExpireIn(config('app.debug') ? now()->addMonths(2) : now()->addHours(2));
        Passport::refreshTokensExpireIn(config('app.debug') ? now()->addMonths(3) : now()->addHours(6));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Passport::useTokenModel(Token::class);
    }
}
