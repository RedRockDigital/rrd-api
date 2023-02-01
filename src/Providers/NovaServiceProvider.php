<?php

namespace RedRockDigital\Api\Providers;

use RedRockDigital\Api\Nova\Blog;
use RedRockDigital\Api\Nova\Dashboards\Main;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use RedRockDigital\Api\Nova\Team;
use RedRockDigital\Api\Nova\User;
use RedRockDigital\Api\Models\User as UserModel;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::resources([
            User::class,
            Team::class,
            Blog::class
        ]);

        Nova::routes()->withAuthenticationRoutes();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function (UserModel $user) {
            return Str::after($user->email, '@') === env('NOVA_EMAIL_DOMAIN');
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
