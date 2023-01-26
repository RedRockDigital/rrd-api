<?php

namespace RedRockDigital\Api\Database\Seeders\Production;

use RedRockDigital\Database\Seeders\Common\GroupSeeder;
use RedRockDigital\Database\Seeders\Common\RedRockTeamSeeder;
use RedRockDigital\Database\Seeders\Common\RedRockUserSeeder;
use Illuminate\RedRockDigital\Database\Seeder;

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
