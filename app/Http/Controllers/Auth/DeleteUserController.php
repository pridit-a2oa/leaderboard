<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRequestDelete;
use App\Exceptions\InvalidDeleteLinkException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class DeleteUserController extends Controller
{
    /**
     * Create the user deletion process.
     */
    public function create(Request $request): RedirectResponse
    {
        // Generate a user deletion token
        $request->user()->delete_token = Password::broker()->getRepository()->createNewToken();
        $request->user()->save();

        event(new UserRequestDelete($request->user()));

        $request->session()
            ->flash(
                'message',
                ['warning', 'Please check your email for a confirmation link']
            );

        return redirect(route('user.setting.delete'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->route()->parameters(), [
            'token' => 'required|string',
        ])->validated();

        $user = User::where('delete_token', $validator['token'])
            ->firstOr(['*'], function () {
                throw new InvalidDeleteLinkException(
                    __('The confirmation link is not valid')
                );
            });

        Auth::logout();

        // Soft delete the user (triggers prune)
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
