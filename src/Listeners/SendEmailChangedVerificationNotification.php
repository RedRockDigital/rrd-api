<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Notifications\VerifyEmailNotification;

class SendEmailChangedVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        if ($event->user->getOriginal('email') !== $event->user->email) {
            $event->user->updateQuietly([
                'email_verified_at' => null,
            ]);

            $event->user->notify(new VerifyEmailNotification(false, true));
        }
    }
}
