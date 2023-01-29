<?php

namespace RedRockDigital\Api\Events;

use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserInvitedToTeam
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user, public bool $new, public Team $team, public User $invitedBy)
    {
    }
}
