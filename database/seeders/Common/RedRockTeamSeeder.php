<?php

namespace RedRockDigital\Database\Seeders\Common;

use RedRockDigital\Api\Models\Group;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use Illuminate\RedRockDigital\Database\Seeder;

class RedRockTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $ownerGroupId = Group::where('ref', 'OWNER')->first()->id;

        $team = Team::create([
            'name'          => 'Red Rock',
            'owner_id'      => User::where('email', 'LIKE', '%@redrockdigital.dev')->first()->id,
            'has_onboarded' => true,
        ]);

        $team->users()->attach(User::where('email', 'LIKE', '%@redrockdigital.dev')->get()->pluck('id'), [
            'group_id' => $ownerGroupId,
        ]);
    }
}
