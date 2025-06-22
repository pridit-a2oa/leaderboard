<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id64' => '76561197992228102',
            'name' => ucfirst(fake()->userName()),
            'score' => fake()->randomNumber(4, false),
            'last_seen_at' => now()->sub(random_int(1, 14), 'day'),
        ];
    }

    /**
     * Indicate that the character is inactive.
     */
    public function inactive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'last_seen_at' => now()->subDays(43),
            ];
        });
    }
}
