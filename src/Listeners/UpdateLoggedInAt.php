<?php

namespace RedRockDigital\Api\Listeners;

use RedRockDigital\Api\Models\User;
use Laravel\Passport\Events\AccessTokenCreated;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UpdateLoggedInAt
{
    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(AccessTokenCreated $event): void
    {
        // check if the event is being triggered by a login
        if (request()->get('grant_type') === 'password') {
            User::where('id', $event->userId)->update([
                'last_logged_in_at' => now(),
            ]);
        }
    }
}
