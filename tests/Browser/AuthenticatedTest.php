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

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    public function test_can_see_authenticated_state_as_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->assertSee('Account');
        });
    }

    public function test_can_access_settings_page_as_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/')
                ->press('@account-button')
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
                ->press('@account-button')
                ->press('Sign out')
                ->waitUntilMissing('#nprogress')
                ->assertPresent('@login-button');
        });
    }
}
