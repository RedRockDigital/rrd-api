<?php

namespace RedRockDigital\Database\Seeders\Staging;

use RedRockDigital\Database\Seeders\Common\GroupSeeder;
use RedRockDigital\Database\Seeders\Common\RedRockTeamSeeder;
use RedRockDigital\Database\Seeders\Common\RedRockUserSeeder;
use Illuminate\RedRockDigital\Database\Seeder;

class StagingSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call([
            GroupSeeder::class,
            RedRockUserSeeder::class,
            RedRockTeamSeeder::class,
        ]);
    }
}
