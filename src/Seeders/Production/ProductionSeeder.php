<?php

namespace RedRockDigital\Api\Seeders\Production;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Seeders\Common\GroupSeeder;
use RedRockDigital\Api\Seeders\Common\RedRockTeamSeeder;
use RedRockDigital\Api\Seeders\Common\RedRockUserSeeder;
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
