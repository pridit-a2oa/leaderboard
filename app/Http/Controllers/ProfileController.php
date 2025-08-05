<?php

namespace App\Http\Controllers;

use App\Events\UserVerifyEmail;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validated();

        if (! is_null($request->safe()->email)) {
            if ($request->user()->is_verification_email_throttled) {
                return back()->withErrors([
                    'email' => 'Rate limited, please try again later',
                ]);
            }

            event(new UserVerifyEmail($request->user(), $request->safe()->email));

            if (! $request->user()->hasVerifiedEmail()) {
                // Since the user is adding an email for the first time, allow
                // an immediate re-attempt for either resending or reentering as
                // a better UX in case of a mistake or otherwise
                if ($request->user()->email === null) {
                    RateLimiter::clear(sprintf('verification-email:%d', $request->user()->id));
                }

                $request->user()->update(['email' => $request->safe()->email]);
            }
        }

        return redirect(route('user.setting.account', absolute: false));
    }
}
