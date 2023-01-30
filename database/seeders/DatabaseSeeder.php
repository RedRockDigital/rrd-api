<?php

namespace RedRockDigital\Api\Database\Seeders;

use RedRockDigital\Api\Database\Seeders\Local\LocalSeeder;
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
