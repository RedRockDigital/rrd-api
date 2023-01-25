<?php

namespace RedRockDigital\Database\Seeders\Local;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Enums\InformEnums;
use RedRockDigital\Api\Models\Group;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use RedRockDigital\Database\Seeders\Common\GroupSeeder;

class LocalSeeder extends Seeder
{
    /**
     * @return void
     *
     * @throws \Exception
     */
    public function run(): void
    {
        $this->call(GroupSeeder::class);

        $groups = Group::all();

        // Get the Event Dispatcher
        // Forget the TeamCreated Event, we don't want to send to Stripe
        $teamEventDispatcher = Team::getEventDispatcher();
        $teamEventDispatcher->forget('RedRockDigital\Api\Events\TeamCreated');
        // Set back the Event Dispatcher
        Team::setEventDispatcher($teamEventDispatcher);

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
}
