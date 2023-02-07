<?php

namespace RedRockDigital\Api\Seeders;

use RedRockDigital\Api\Seeders\Local\LocalSeeder;
use Illuminate\RedRockDigital\DatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocalSeeder::class);
    }
}
