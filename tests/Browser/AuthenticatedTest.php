<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticatedTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'John',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_can_see_name_as_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->assertSee('John');
        });
    }

    public function test_can_access_settings_page_as_user(): void
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

    public function test_can_log_out_as_user(): void
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
