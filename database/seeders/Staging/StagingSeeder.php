<?php

namespace RedRockDigital\Database\Seeders\Staging;

use Illuminate\Database\Seeder;
use RedRockDigital\DatabaseSeeders\Common\GroupSeeder;
use RedRockDigital\DatabaseSeeders\Common\RedRockTeamSeeder;
use RedRockDigital\DatabaseSeeders\Common\RedRockUserSeeder;
use Illuminate\RedRockDigital\DatabaseSeeder;

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
