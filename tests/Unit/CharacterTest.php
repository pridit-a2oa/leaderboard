<?php

namespace Tests\Unit;

use App\Models\Character;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_see_three_characters(): void
    {
        Character::factory(3)->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data', 3)
            );
    }

    public function test_cannot_see_zero_score_character(): void
    {
        Character::factory()->create([
            'score' => 0,
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->missing('characters.meta')
            );
    }

    public function test_can_see_highest_scoring_character_first(): void
    {
        $maxScore = Character::factory(10)->create()->max('score');

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->where('characters.data.0.score', $maxScore)
            );
    }

    public function test_can_see_lowest_scoring_character_last(): void
    {
        $minScore = Character::factory(10)->create()->min('score');

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->where('characters.data.9.score', $minScore)
            );
    }

    public function test_can_see_character_last_seen_before_six_weeks(): void
    {
        Character::factory()->create([
            'last_seen_at' => now()->subDays(41),
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.meta')
            );
    }

    public function test_can_see_character_last_seen_after_six_weeks_as_supporter(): void
    {
        Character::factory()->for(User::factory()->supporter())->create([
            'last_seen_at' => now()->subDays(43),
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.meta')
            );
    }

    public function test_cannot_see_character_last_seen_after_six_weeks(): void
    {
        Character::factory()->create([
            'last_seen_at' => now()->subDays(43),
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->missing('characters.meta')
            );
    }

    public function test_cannot_see_character_statistics_with_none_and_not_linked(): void
    {
        Character::factory()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    }

    public function test_cannot_see_character_statistics_with_one_and_not_linked(): void
    {
        Character::factory()->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    }

    public function test_can_see_character_statistics_with_one_and_linked(): void
    {
        Character::factory()->for(User::factory())->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 1)
            );
    }
}
