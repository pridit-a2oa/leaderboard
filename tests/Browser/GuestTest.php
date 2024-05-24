<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestTest extends DuskTestCase
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

    public function test_can_log_in_as_guest(): void
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
}
