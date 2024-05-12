<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserConnectionController extends Controller
{
    /**
     * Delete the user's connection.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'connection_id' => ['required', 'exists:connections,id'],
        ]);

        // Unassociate all associated characters
        auth()->user()->characters()->update(['user_id' => null]);

        // Detach the connection type
        auth()->user()->connections()->detach($request->connection_id);

        return redirect(route('user.setting.connections', absolute: false));
    }
}
