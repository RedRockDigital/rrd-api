<?php

namespace RedRockDigital\Api\Listeners;

use RedRockDigital\Api\Events\UserInvitedToTeam;
use RedRockDigital\Api\Notifications\UserInviteNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserInviteNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  UserInvitedToTeam  $event
     * @return void
     */
    public function handle(UserInvitedToTeam $event)
    {
        $event->user->notify(new UserInviteNotification($event->new, $event->team, $event->invitedBy));
    }
}
