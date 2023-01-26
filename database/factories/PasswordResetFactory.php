<?php

namespace RedRockDigital\Api\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\RedRockDigital\Api\Models\Group>
 */
class PasswordResetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'    => $this->faker->uuid(),
            'token' => $this->faker->uuid(),
        ];
    }
}
