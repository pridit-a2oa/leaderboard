<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Show the user's settings page.
     */
    public function settings(): Response
    {
        return Inertia::render('Profile/Settings');
    }

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

        return Redirect::to('/settings/delete');
    }

    /**
     * Disconnect a user's connection.
     */
    public function disconnect(Request $request): RedirectResponse
    {
        $request->validate([
            'connection_id' => ['required', 'exists:connections,id'],
        ]);

        // Unassociate all characters
        auth()->user()->characters()->update(['user_id' => null]);

        // Detach the connection
        auth()->user()->connections()->detach($request->connection_id);

        return Redirect::to('/settings/connections');
    }
}
