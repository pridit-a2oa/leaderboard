<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory([
            'password' => Hash::make('password'),
        ]);
    }

    public function test_can_register_account_as_guest(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->user->make();

            $browser->visit('/')
                ->click('@login-button')
                ->press('Sign up')
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->type('#password_confirmation', 'password')
                ->check('conditions')
                ->press('Create account')
                ->waitForText('Account')
                ->assertSee('Account');
        });
    }

    public function test_can_recover_account_as_guest(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->user->create([
                'password' => Hash::make('password'),
            ]);

            $browser->visit(route('password.reset', [
                'token' => Password::broker()->createToken($user),
                'email' => $user->email,
            ]))
                ->type('#reset-password', 'password2')
                ->type('#reset-password_confirmation', 'password2')
                ->press('Reset Password')
                ->waitUntilMissing('button[disabled]')
                ->waitUntilMissing('#nprogress')
                ->assertPathIs('/')
                ->click('@login-button')
                ->type('#email', $user->email)
                ->type('#password', 'password2')
                ->press('Sign in to your account')
                ->waitForText('Account')
                ->assertSee('Account');
        });
    }

    public function test_can_log_in_as_guest(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->user->create();

            $browser->visit('/')
                ->click('@login-button')
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->press('Sign in to your account')
                ->waitForText('Account')
                ->assertSee('Account');
        });
    }
}
