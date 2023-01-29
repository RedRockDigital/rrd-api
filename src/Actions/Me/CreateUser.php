<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\Group;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

/**
 * Final Class CreateUser
 */
final class CreateUser
{
    /**
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string  $email
     * @param  string  $password
     * @param  string|null  $teamId
     * @param  string|null  $referral
     * @return User
     */
    public function __invoke(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $teamId = null,
        string $referral = null,
    ): User {
        $user = User::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $email,
            'password'   => $password,
            'referral'   => $referral,
        ]);

        // If the TeamUuid has not been passed through
        // We want to create a new Team, as we assume they're the owner
        if ($teamId === null) {
            $team = Team::create([
                'name'     => Str::plural($user->first_name).' team',
                'owner_id' => $user->id,
            ]);

            // Giving them the default "Owner" group.
            $group = Group::getDefault();
        } else {
            // However, if the $teamUuid has been passed through
            // We will perform a quick look-up, and attach the User
            $team = Team::findOrFail($teamId);

            // We attach the user with the group "User"
            // As we know at this point they're not an Owner
            $group = Group::getGroup('USER');
        }

        // We attach the user to the team
        $team->users()->attach($user, ['group_id' => $group->id]);

        // Assign the Team they've just been assigned to as their default
        $user->updateQuietly([
            'current_team_id' => $team->id,
        ]);

        event(new Registered($user));

        return $user;
    }
}
