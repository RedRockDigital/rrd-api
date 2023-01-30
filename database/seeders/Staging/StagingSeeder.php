<?php

namespace RedRockDigital\Api\Database\Seeders\Staging;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Database\Seeders\Common\GroupSeeder;
use RedRockDigital\Api\Database\Seeders\Common\RedRockTeamSeeder;
use RedRockDigital\Api\Database\Seeders\Common\RedRockUserSeeder;
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
