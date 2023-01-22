<?php

namespace App\Actions\Team;

use App\Models\{
    Group,
    Team,
};

class CreateTeam
{
    /**
     * @param string $userId
     * @param string $name
     * @return Team
     */
    public function __invoke(string $userId, string $name): Team
    {
        $team = Team::create([
            'owner_id' => $userId,
            'name'     => $name,
        ]);

        $team->users()->attach($userId, [
            'group_id' => Group::getDefault()->id,
        ]);

        return $team;
    }
}
