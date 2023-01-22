<?php

namespace App\Providers;

use App\Events\UserUpdated;
use App\Events\{
    TeamCreated,
    UserInvitedToTeam,
};
use App\Listeners\{
    SendEmailChangedVerificationNotification,
    SendUserInviteNotification,
    Stripe\StripeCustomerCreationListener,
    UpdateLoggedInAt
};
use App\Models\Webhook;
use App\Observers\WebhookObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class         => [
            SendEmailVerificationNotification::class,
        ],
        UserUpdated::class        => [
            SendEmailChangedVerificationNotification::class,
        ],
        TeamCreated::class        => [
            StripeCustomerCreationListener::class,
        ],
        UserInvitedToTeam::class  => [
            SendUserInviteNotification::class,
        ],
        AccessTokenCreated::class => [
            UpdateLoggedInAt::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Webhook::class => [WebhookObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
