<?php

namespace RedRockDigital\Database\Factories;

use RedRockDigital\Api\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Illuminate\Notifications\DatabaseNotification>
 */
class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'              => Str::uuid(),
            'type'            => 'RedRockDigital\Api\Notifications\TestNotification',
            'notifiable_type' => 'RedRockDigital\Api\Models\User',
            'notifiable_id'   => User::factory(),
            'data'            => [
                'message' => $this->faker->sentence(),
                'url'     => $this->faker->url(),
            ],
            'read_at'         => $this->faker->boolean ? $this->faker->dateTimeBetween(now()->subWeeks(2)) : null,
        ];
    }
}
