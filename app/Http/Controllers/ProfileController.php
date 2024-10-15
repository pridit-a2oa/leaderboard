<?php

namespace App\Http\Controllers;

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
            $request->user()->newEmail($request->safe()->email);
        }

        return redirect(route('user.setting.account', absolute: false));
    }
}
