<?php

namespace RedRockDigital\Api\Seeders\Local;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Seeders\Common\GroupSeeder;

class LocalSeeder extends Seeder
{
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
        $this->call(TeamSeeder::class);
        $this->call(DevUserSeeder::class);
        $this->call(NotificationsSeeder::class);
    }
}
