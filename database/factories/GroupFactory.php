<?php

namespace RedRockDigital\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\RedRockDigital\Api\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->randomElement(['Owner', 'Admin', 'User']);

        return [
            'name' => $name,
            'ref'  => Str::snake(strtoupper($name)),
        ];
    }
}
