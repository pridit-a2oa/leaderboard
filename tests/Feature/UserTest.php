<?php

use App\Models\Contribution;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('role', function () {
    test('member by default', function () {
        $this->assertTrue($this->user->hasRole('member'));
    });

    test('supporter when contributed and verifies email', function () {
        Contribution::factory(['email' => $this->user->email])->create();

        $this->user->email_verified_at = now();
        $this->user->save();

        $this->assertTrue($this->user->hasRole('supporter'));
    });
});
