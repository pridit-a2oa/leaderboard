<?php

namespace App\Http\Controllers;

use App\Events\UserVerifyEmail;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->safe()->only('email')) {
            if ($request->user()->is_verification_email_throttled) {
                $request->session()
                    ->flash(
                        'message',
                        ['error', 'Please wait before attempting so soon']
                    );

                return back();
            }

            event(new UserVerifyEmail($request->user(), $request->safe()->email));

            if (! $request->user()->hasVerifiedEmail()) {
                $request->user()->update(['email' => $request->safe()->email]);
            }
        }

        return redirect(route('user.setting.account', absolute: false));
    }
}
