<?php

namespace RedRockDigital\Api\Actions\Team;

use RedRockDigital\Api\Events\UserInvitedToTeam;
use RedRockDigital\Api\Http\Requests\Team\CreateUserRequest;
use RedRockDigital\Api\Models\User;

class InviteUser
{
    /**
     * @param  CreateUserRequest  $request
     * @return User
     */
    public function __invoke(CreateUserRequest $request): User
    {
        $user = User::firstOrCreate([
            'email'           => $request->get('email'),
            'current_team_id' => team()->id,
        ], []);

        team()->users()->attach($user, [
            'group_id' => $request->get('group_id'),
        ]);

        event(new UserInvitedToTeam($user, $user->wasRecentlyCreated, team(), $request->user()));

        return $user;
    }
}
