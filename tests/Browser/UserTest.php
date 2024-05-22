<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'John',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_can_user_see_log_in_button(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Log in');
        });
    }

    public function test_can_user_log_in(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->press('Log in')
                ->type('#email', $this->user->email)
                ->type('#password', 'password')
                ->press('Log in to your account')
                ->waitUntilMissing('button[disabled]')
                ->assertSee('John');
        });
    }

    public function test_can_logged_in_user_see_name(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->assertSee('John');
        });
    }

    public function test_can_logged_in_user_access_settings(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->press($this->user->name)
                ->clickLink('Settings')
                ->waitUntilMissing('#nprogress')
                ->assertSee('Account');
        });
    }

    public function test_can_logged_in_user_log_out(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->press($this->user->name)
                ->press('Log out')
                ->waitUntilMissing('#nprogress')
                ->assertSee('Log in');
        });
    }
}
