<?php

use App\Models\Character;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

describe('characters', function () {
    test('can see placeholders', function () {
        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data', 5)
                ->where('characters.data.0.id64', null)
            );
    });

    test('can see three', function () {
        Character::factory(3)->create();

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data', 3)
            );
    });
});

describe('score', function () {
    test('zero score character missing', function () {
        Character::factory()->create([
            'score' => 0,
        ]);

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->missing('characters.meta')
            );
    });

    test('highest score duplicate only', function () {
        $maxScore = Character::factory(2)->create([
            'name' => 'Test',
        ])->max('score');

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data', 1)
                ->where('characters.data.0.score', $maxScore)
            );
    });

    test('highest scorer is first', function () {
        $maxScore = Character::factory(10)->create()->max('score');

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->where('characters.data.0.score', $maxScore)
            );
    });

    test('lowest scorer is last', function () {
        $minScore = Character::factory(10)->create()->min('score');

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->where('characters.data.9.score', $minScore)
            );
    });
});

describe('statistics', function () {
    test('none when none and not linked', function () {
        Character::factory()->create();

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    });

    test('none when one and not linked', function () {
        Character::factory()->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 0)
            );
    });

    test('one when linked', function () {
        Character::factory()->for(User::factory())->hasStatistics()->create();

        $this->get('/')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home')
                ->has('characters.data.0.relations.statistics', 1)
            );
    });
});
