<?php

use App\Events\UserDeleted;
use App\Events\UserRequestDelete;
use App\Events\UserVerifyEmail;
use App\Models\Character;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->user = User::factory()
        ->hasAttached(
            Connection::firstWhere('name', 'steam'),
            ['identifier' => '1'],
            'connections'
        )
        ->create([
            'email' => null,
        ]);
});

test('has authenticated state', function () {
    $this->actingAs($this->user)
        ->visit('/')
        ->assertSee('Account');

    $this->assertAuthenticated();
});

test('has settings page', function () {
    $this->actingAs($this->user)
        ->visit('/')
        ->press('Account')
        ->click('Settings')
        ->assertPathIs('/settings/account');
});

test('can update email', function () {
    Event::fake();

    $this->actingAs($this->user)
        ->visit('/settings/account')
        ->type('email', 'john@doe.com')
        ->press('@save-email')
        ->assertSee('Check your email for a verification link');

    Event::assertDispatched(UserVerifyEmail::class);
});

describe('preferences', function () {
    test('can hide steam community url', function () {
        Character::factory()->create([
            'user_id' => $this->user->id,
            'id64' => 1,
        ]);

        $this->visit('/')
            ->assertSourceHas('https://steamcommunity.com');

        $this->actingAs($this->user)
            ->visit('/settings/account')
            ->check('steam')
            ->press('@save-preferences')
            ->assertSee('Saved changes');

        $this->visit('/')
            ->assertSourceMissing('https://steamcommunity.com');
    });

    test('can override avatar with gravatar', function () {
        Character::factory()->create([
            'user_id' => $this->user->id,
            'id64' => '1',
        ]);

        $this->user->update([
            'email' => 'john@doe.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($this->user->fresh())
            ->visit('/')
            ->assertSourceMissing(
                'https://secure.gravatar.com'
            )
            ->navigate('/settings/account')
            ->check('gravatar')
            ->press('@save-preferences')
            ->assertSee('Saved changes');

        $this->actingAs($this->user->fresh())
            ->visit('/')
            ->assertSourceHas(
                'https://secure.gravatar.com'
            );
    });
});

test('can delete account', function () {
    Event::fake();

    $this->actingAs($this->user)
        ->visit('/settings/delete')
        ->check('confirm');

    Event::assertDispatched(UserDeleted::class);

    $this->assertGuest();
});

test('can receive delete account confirmation', function () {
    Event::fake();

    $this->user->update([
        'email' => 'john@doe.com',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->user->fresh())
        ->visit('/settings/delete')
        ->check('confirm')
        ->assertSee('Please check your email for a confirmation link');

    Event::assertDispatched(UserRequestDelete::class);
});

test('can sign out', function () {
    $this->actingAs($this->user)
        ->visit('/')
        ->press('Account')
        ->press('Sign out');

    $this->assertGuest();
});
