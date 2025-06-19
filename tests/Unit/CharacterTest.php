<?php

namespace Tests\Unit;

use App\Models\Character;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function can_see_three_characters(): void
    {
        Character::factory(3)->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data', 3)
            );
    }

    #[Test]
    public function cannot_see_zero_score_character(): void
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

    #[Test]
    public function can_see_highest_scoring_character_first(): void
    {
        $maxScore = Character::factory(10)->create()->max('score');

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->where('characters.data.0.score', $maxScore)
            );
    }

    #[Test]
    public function can_see_lowest_scoring_character_last(): void
    {
        $minScore = Character::factory(10)->create()->min('score');

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->where('characters.data.9.score', $minScore)
            );
    }

    #[Test]
    public function cannot_see_character_statistics_with_none_and_not_linked(): void
    {
        Character::factory()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    }

    #[Test]
    public function cannot_see_character_statistics_with_one_and_not_linked(): void
    {
        Character::factory()->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    }

    #[Test]
    public function can_see_character_statistics_with_one_and_linked(): void
    {
        Character::factory()->for(User::factory())->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 1)
            );
    }
}
