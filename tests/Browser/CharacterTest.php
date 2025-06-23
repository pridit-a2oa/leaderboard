<?php

namespace Tests\Browser;

use App\Models\Character;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CharacterTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_can_see_character(): void
    {
        $this->browse(function (Browser $browser) {
            $character = Character::factory()->create();

            $browser->visit('/')
                ->assertSee($character->name);
        });
    }

    public function test_can_link_linkable_character(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            Character::factory()->create([
                'id64' => $id64,
            ]);

            $user = User::factory()->hasAttached(
                Connection::factory()->steam(),
                ['identifier' => $id64]
            )->create();

            $browser->loginAs($user)
                ->visit('/')
                ->assertPresent('@link-button')
                ->press('LINK')
                ->visit('/')
                ->waitForText('YOU')
                ->assertSee('YOU');
        });
    }

    public function test_can_toggle_visibility_of_character(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            $user = User::factory()->hasCharacters([
                'id64' => $id64,
            ])
                ->hasAttached(
                    Connection::factory()->steam(),
                    ['identifier' => $id64]
                )
                ->create();

            $browser->loginAs($user)
                ->visit('/settings/characters')
                ->click('@visibility-button')
                ->waitUntilMissing('#nprogress')
                ->loginAs(User::create())
                ->visit('/')
                ->assertSee('Anonymous');
        });
    }

    public function test_can_unlink_then_relink_character(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            $user = User::factory()->hasCharacters([
                'id64' => $id64,
            ])
                ->hasAttached(
                    Connection::factory()->steam(),
                    ['identifier' => $id64]
                )
                ->create();

            $browser->loginAs($user)
                ->visit('/')
                ->assertMissing('@link-button')
                ->visit('/settings/characters')
                ->click('@unlink-button')
                ->waitUntilMissing('#nprogress')
                ->assertSee('You have no linked characters')
                ->visit('/')
                ->assertPresent('@link-button')
                ->press('LINK')
                ->visit('/')
                ->waitForText('YOU')
                ->assertSee('YOU');
        });
    }

    public function test_cannot_link_two_characters_as_user(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            Character::factory()->create([
                'id64' => $id64,
            ]);

            $user = User::factory()->hasCharacters()
                ->hasAttached(
                    Connection::factory()->steam(),
                    ['identifier' => $id64]
                )
                ->create();

            $browser->loginAs($user)
                ->visit('/')
                ->clickLink('Link')
                ->waitUntilMissing('#nprogress')
                ->assertPathIs('/settings/extras');
        });
    }

    public function test_can_link_two_characters_as_supporter(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            Character::factory()->create([
                'id64' => $id64,
            ]);

            $user = User::factory()->hasCharacters([
                'id64' => $id64,
            ])
                ->hasAttached(
                    Connection::factory()->steam(),
                    ['identifier' => $id64]
                )
                ->create()
                ->syncRoles('supporter');

            $browser->loginAs($user)
                ->visit('/')
                ->press('LINK')
                ->waitUntilMissing('#nprogress')
                ->assertPathIs('/settings/characters');
        });
    }

    public function test_can_reset_character_statistics_as_supporter(): void
    {
        $this->browse(function (Browser $browser) {
            $id64 = 1;

            $user = User::factory()->has(
                Character::factory(['id64' => $id64])
                    ->hasStatistics()
            )
                ->hasAttached(
                    Connection::factory()->steam(),
                    ['identifier' => $id64]
                )
                ->create()
                ->syncRoles('supporter');

            $character = $user->characters->first()->name;

            $browser->loginAs($user)
                ->visit('/')
                ->assertSee($character)
                ->visit('/settings/characters')
                ->assertPresent('@reset-button')
                ->click('@reset-button')
                ->waitUntilMissing('#nprogress')
                ->assertMissing('@reset-button');
        });
    }
}
