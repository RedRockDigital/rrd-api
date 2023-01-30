<?php

namespace RedRockDigital\Api\Database\Seeders\Common;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Models\User;
use Illuminate\RedRockDigital\DatabaseSeeder;

class RedRockUserSeeder extends Seeder
{
    /**
     * @var array|\string[][]
     */
    protected array $users = [
        [
            'first_name' => 'Thomas',
            'last_name'  => 'Palmer',
            'email'      => 'thomas@redrockdigital.dev',
            'password'   => '$2y$10$cwzMU9uwLITwbjxRvqrrY.PN2djW.0lH.FUc2lQMqLnJdCTPxjtXS',
        ],
        [
            'first_name' => 'Jamie',
            'last_name'  => 'Nicol',
            'email'      => 'jamie@redrockdigital.dev',
            'password'   => '$2y$10$cwzMU9uwLITwbjxRvqrrY.PN2djW.0lH.FUc2lQMqLnJdCTPxjtXS',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            User::create($user);
        }
    }
}
