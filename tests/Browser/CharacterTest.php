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

    public function test_cannot_see_any_characters(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('No records found');
        });
    }

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
            Character::factory()->create([
                'guid' => '1',
            ]);

            $user = User::factory()->hasAttached(
                Connection::factory(),
                ['identifier' => '1']
            )->create();

            $browser->loginAs($user)
                ->visit('/')
                ->press('LINK')
                ->waitUntilMissing('#nprogress')
                ->assertSee('YOU');
        });
    }

    public function test_can_toggle_visibility_of_character(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->hasCharacters(['guid' => '1'])->hasAttached(
                Connection::factory(),
                ['identifier' => '1']
            )->create();

            $browser->loginAs($user)
                ->visit('/settings/characters')
                ->click('@visibility-button')
                ->waitUntilMissing('#nprogress')
                ->visit('/')
                ->assertSee('Anonymous');
        });
    }

    public function test_can_unlink_then_relink_character(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->hasCharacters(['guid' => '1'])->hasAttached(
                Connection::factory(),
                ['identifier' => '1']
            )->create();

            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('YOU')
                ->visit('/settings/characters')
                ->click('@unlink-button')
                ->waitUntilMissing('#nprogress')
                ->assertSee('You have no linked characters')
                ->visit('/')
                ->press('LINK')
                ->waitUntilMissing('#nprogress')
                ->assertSee('YOU');
        });
    }

    public function test_cannot_link_two_characters_as_user(): void
    {
        $this->browse(function (Browser $browser) {
            $character = Character::factory()->create([
                'guid' => '1',
            ]);

            $user = User::factory()->hasCharacters()
                ->hasAttached(
                    Connection::factory(),
                    ['identifier' => '1']
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
            $character = Character::factory()->create([
                'guid' => '1',
            ]);

            $user = User::factory()->hasCharacters()
                ->hasAttached(
                    Connection::factory(),
                    ['identifier' => '1']
                )
                ->create()
                ->syncRoles('supporter');

            $browser->loginAs($user)
                ->visit('/')
                ->press('LINK')
                ->waitUntilMissing('#nprogress')
                ->assertPathIs('/');
        });
    }

    public function test_can_reset_character_as_supporter(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->hasCharacters(['guid' => '1'])
                ->hasAttached(
                    Connection::factory(),
                    ['identifier' => '1']
                )
                ->create()
                ->syncRoles('supporter');

            $character = $user->characters->first()->name;

            $browser->loginAs($user)
                ->visit('/')
                ->assertSee($character)
                ->visit('/settings/characters')
                ->click('@reset-button')
                ->waitUntilMissing('#nprogress')
                ->visit('/')
                ->assertSee('No records found');
        });
    }
}
