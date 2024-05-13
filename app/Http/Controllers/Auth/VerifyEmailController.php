<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
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

        $request->session()->flash('message', true);

        return redirect(route('user.setting.account', absolute: false));
    }
}
