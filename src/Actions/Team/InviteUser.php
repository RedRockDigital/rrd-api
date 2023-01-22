<?php

namespace App\Actions\Team;

use App\Events\UserInvitedToTeam;
use App\Http\Requests\Team\CreateUserRequest;
use App\Models\User;

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
