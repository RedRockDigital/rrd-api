<?php

namespace RedRockDigital\Api\Database\Seeders;

use RedRockDigital\Database\Seeders\Local\LocalSeeder;
use Illuminate\RedRockDigital\Database\Seeder;

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
