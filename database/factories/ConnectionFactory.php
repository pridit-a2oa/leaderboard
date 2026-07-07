<?php

namespace Database\Factories;

use App\Models\Connection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Connection>
 */
class ConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'icon' => 'steam',
        ];
    }

    /**
     * Indicate that the model's name is Steam.
     */
    public function steam(): static
    {
        return $this->state(fn () => [
            'name' => 'steam',
        ]);
    }
}
