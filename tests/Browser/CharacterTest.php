<?php

use App\Models\Character;
use App\Models\Connection;
use App\Models\User;

test('has home', function () {
    $this->get('/')
        ->assertStatus(200);
});

test('has a character', function () {
    $character = Character::factory()->create();

    $this->visit('/')
        ->assertSee($character->name);
});

test('can link character', function () {
    $id64 = 1;

    Character::factory()->create([
        'id64' => $id64,
    ]);

    $user = User::factory()
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertPresent('@link')
        ->click('@link')
        ->assertPathIs('/settings/characters')
        ->navigate('/')
        ->assertSee('YOU');
});

test('can anonymize character', function () {
    $id64 = 1;

    $user = User::factory()->hasCharacters([
        'id64' => $id64,
    ])
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/settings/characters')
        ->assertPresent('@visibility')
        ->press('@visibility')
        ->navigate('/')
        ->click('Account')
        ->click('Sign out')
        ->assertSee('Anonymous');

    $this->assertGuest();
});

test('can relink character', function () {
    $id64 = 1;

    $user = User::factory()->hasCharacters([
        'id64' => $id64,
    ])
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertMissing('@link')
        ->navigate('/settings/characters')
        ->assertPresent('@unlink')
        ->click('@unlink')
        ->assertSee('You have no linked characters')
        ->navigate('/')
        ->assertPresent('@link')
        ->click('@link')
        ->navigate('/')
        ->assertSee('YOU');
});

test('cannot link multiple characters', function () {
    $id64 = 1;

    Character::factory()->create([
        'id64' => $id64,
    ]);

    $user = User::factory()->hasCharacters()
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertPresent('@link')
        ->click('@link')
        ->assertPathIs('/settings/extras');
});

test('can link multiple characters as supporter', function () {
    $id64 = 1;

    Character::factory()->create([
        'id64' => $id64,
    ]);

    $user = User::factory()->hasCharacters([
        'id64' => $id64,
    ])
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->syncRoles('supporter')
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertPresent('@link')
        ->click('@link')
        ->assertPathIs('/settings/characters');
});

test('cannot reset character statistics', function () {
    $id64 = 1;

    $user = User::factory()->has(
        Character::factory(['id64' => $id64])
            ->hasStatistics()
    )
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertSee($user->characters->first()->name)
        ->navigate('/settings/characters')
        ->assertMissing('@reset');
});

test('can reset character statistics as supporter', function () {
    $id64 = 1;

    $user = User::factory()->has(
        Character::factory(['id64' => $id64])
            ->hasStatistics()
    )
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => $id64],
            'connections'
        )
        ->create()
        ->syncRoles('supporter')
        ->fresh('connections');

    $this->actingAs($user)
        ->visit('/')
        ->assertSee($user->characters->first()->name)
        ->navigate('/settings/characters')
        ->assertPresent('@reset')
        ->click('@reset')
        ->assertMissing('@reset');
});
