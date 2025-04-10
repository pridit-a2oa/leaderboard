<?php

namespace Tests\Unit;

use App\Models\Contribution;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function role_is_member(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(
            $user->hasRole('member')
        );
    }

    #[Test]
    public function role_is_supporter_when_contributed_and_verifies_email(): void
    {
        $user = User::factory()->create();

        Contribution::factory(['email' => $user->email])->create();

        $user->email_verified_at = now();
        $user->save();

        $this->assertTrue(
            $user->hasRole('supporter')
        );
    }
}
