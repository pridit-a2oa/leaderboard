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
            'id64' => fake()->regexify('7656119\d{10}'),
            'name' => ucfirst(fake()->unique()->userName()),
            'score' => fake()->randomNumber(4, false),
            'last_seen_at' => now()->sub(random_int(1, 16), 'week'),
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
