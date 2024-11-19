<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResendVerificationEmailController extends Controller
{
    /**
     * Resend email verification email.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        event(new UserVerifyEmail($request->user(), $request->user()->email));

        return redirect(route('user.setting.account', absolute: false));
    }
}
