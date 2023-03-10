<?php

namespace RedRockDigital\Api\Seeders\Local;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Enums\InformEnums;
use RedRockDigital\Api\Models\Group;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use RedRockDigital\Api\Services\Payments\Payments;
use Illuminate\RedRockDigital\DatabaseSeeder;

class DevUserSeeder extends Seeder
{
    const DEV_TEAM_NAME = 'Red Rock Dev';

    /**
     * @var array|\string[][]
     */
    protected array $users = [
        [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'admin@redrockdigital.dev',
        ],
        [
            'first_name' => 'Silvia',
            'last_name'  => 'Smith',
            'email'      => 'user@redrockdigital.dev',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            $user = User::create(
                array_merge($user, [
                    'password' => env('SEEDER_PASSWORD', 'password'),
                ])
            );

            $user->markEmailAsVerified();
        }

        $team = Team::create([
            'name'          => self::DEV_TEAM_NAME,
            'owner_id'      => $ownerId = User::where('email', 'admin@redrockdigital.dev')->first()->id,
            'has_onboarded' => true,
        ]);

        $team->update([
            'allowances' => Payments::getAllowances($team),
        ]);

        $team->users()->attach($ownerId, [
            'group_id' => Group::where('ref', 'OWNER')->first()->id,
        ]);

        $team->users()->attach(User::where('email', 'user@redrockdigital.dev')->first()->id, [
            'group_id' => Group::where('ref', 'USER')->first()->id,
        ]);

        User::where('email', 'like', '%@redrockdigital.dev')
            ->each(static function (User $user) use ($team) {
                $user->inform(InformEnums::RECEIVE_PROMOTIONAL);
                $user->update(['current_team_id' => $team->id]);
            });
    }
}
