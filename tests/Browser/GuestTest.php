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

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory([
            'name' => 'John',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_can_register_account_as_guest(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->user->make();

            $browser->visit('/')
                ->press('Log in')
                ->press('Sign up')
                ->type('#name', $user->name)
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->type('#password_confirmation', 'password')
                ->check('conditions')
                ->press('Register an account')
                ->waitUntilMissing('button[disabled]')
                ->assertSee('John');
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
                ->waitUntilMissing('#nprogress')
                ->press('Log in')
                ->type('#email', $user->email)
                ->type('#password', 'password2')
                ->press('Log in to your account')
                ->waitUntilMissing('button[disabled]')
                ->assertSee($user->name);
        });
    }

    public function test_can_log_in_as_guest(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->user->create();

            $browser->visit('/')
                ->press('Log in')
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->press('Log in to your account')
                ->waitUntilMissing('button[disabled]')
                ->assertSee('John');
        });
    }
}
