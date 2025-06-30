<?php

use App\Models\Contribution;
use App\Models\User;

describe('role', function () {
    test('assigned member by default', function () {
        $user = User::factory()->create();

        expect($user->hasRole('member'))->toBe(true);
    });

    test('assigned supporter when contributed and verifies email', function () {
        $user = User::factory()->create();

        Contribution::factory(['email' => $user->email])->create();

        $user->email_verified_at = now();
        $user->save();

        expect($user->hasRole('supporter'))->toBe(true);
    });
});
