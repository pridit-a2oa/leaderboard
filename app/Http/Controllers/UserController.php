<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Delete the user's account.
     */
    public function delete(Request $request): RedirectResponse
    {
        $request->session()
            ->flash(
                'message',
                ['warning', 'Please check your email for a confirmation link']
            );

        return redirect(route('user.setting.delete', absolute: false));
    }
}
