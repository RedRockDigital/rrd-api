<?php

namespace RedRockDigital\Api\Seeders\Staging;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Seeders\Common\GroupSeeder;
use RedRockDigital\Api\Seeders\Common\RedRockTeamSeeder;
use RedRockDigital\Api\Seeders\Common\RedRockUserSeeder;
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
