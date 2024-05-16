<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelVerifyNewEmail\Http\InvalidVerificationLinkException;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $user = app(config('verify-new-email.model'))
            ->whereToken($token)
            ->firstOr(['*'], function () {
                throw new InvalidVerificationLinkException(
                    __('The verification link is not valid anymore.')
                );
            })
            ->tap(function ($pendingUserEmail) {
                $pendingUserEmail->activate();
            })
            ->user;

        $request->session()->flash('message', [
            'success', 'Your email address was verified',
        ]);

        return redirect(route('user.setting.account', absolute: false));
    }
}
