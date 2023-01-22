<?php

namespace App\Actions\Team;

use App\Models\{Group, User};
use Illuminate\Validation\ValidationException;

class RemoveUserFromTeam
{
    /**
     * @param User $user
     * @return User
     * @throws ValidationException
     */
    public function __invoke(User $user): User
    {
        // Check that there is another owner on the team
        $defaultGroup = Group::getDefault();

        $hasAnotherOwner = team()->users()
            ->where('id', '!=', $user->id)
            ->wherePivot('group_id', $defaultGroup->id)
            ->exists();

        if (!$hasAnotherOwner) {
            throw ValidationException::withMessages([
                'group' => __('You are attempting to remove the only owner for the account'),
            ]);
        }

        team()->users()->detach($user->id);

        return $user;
    }
}
