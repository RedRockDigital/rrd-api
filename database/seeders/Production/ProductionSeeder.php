<?php

namespace RedRockDigital\Api\Database\Seeders\Production;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\DatabaseSeeders\Common\GroupSeeder;
use RedRockDigital\Api\DatabaseSeeders\Common\RedRockTeamSeeder;
use RedRockDigital\Api\DatabaseSeeders\Common\RedRockUserSeeder;
use Illuminate\RedRockDigital\DatabaseSeeder;

class ProductionSeeder extends Seeder
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
