<?php

namespace RedRockDigital\Api\Seeders\Local;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Enums\InformEnums;
use RedRockDigital\Api\Models\{
    Group,
    Team,
    User
};
use RedRockDigital\Api\Seeders\Common\GroupSeeder;

class LocalSeeder extends Seeder
{
    /**
     * Create a new seeder instance.
     */
    public function __construct()
    {
        $this->forgetTeamCreatedEvent();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run(): void
    {
        $this->call(GroupSeeder::class);

        $groups = Group::all();

        Team::factory()->count(5)->create()->each(function (Team $team) use ($groups) {
            for ($x = 1; $x <= random_int(2, 20); $x++) {
                $team->users()->attach(User::factory()->create(), [
                    'group_id' => $groups->random()->id,
                ]);
            }

            $team->inform(InformEnums::RECEIVE_PROMOTIONAL);
        });

        $this->call(DevUserSeeder::class);
        $this->call(NotificationsSeeder::class);
    }

    /**
     * This is a fix to prevent the TeamCreated event from firing when seeding the database.
     *
     * @return void
     */
    private function forgetTeamCreatedEvent()
    {
        $teamEventDispatcher = Team::getEventDispatcher();
        $teamEventDispatcher->forget('RedRockDigital\Api\Events\TeamCreated');

        Team::setEventDispatcher($teamEventDispatcher);
    }
}
