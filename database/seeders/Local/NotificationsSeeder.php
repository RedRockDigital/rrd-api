<?php

namespace RedRockDigital\Database\Seeders\Local;

use RedRockDigital\Api\Models\User;
use RedRockDigital\Database\Factories\DatabaseNotificationFactory;
use Illuminate\RedRockDigital\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::get()->each(function ($user) {
            DatabaseNotificationFactory::new()->create([
                'read_at'       => null,
                'notifiable_id' => $user->id,
            ]);

            DatabaseNotificationFactory::new()->create([
                'read_at'       => now(),
                'notifiable_id' => $user->id,
            ]);

            DatabaseNotificationFactory::times(random_int(2, 10))->create([
                'notifiable_id' => $user->id,
            ]);
        });
    }
}
