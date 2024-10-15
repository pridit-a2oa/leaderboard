<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConnectionController extends Controller
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
        $request->user()->characters()->update(['user_id' => null]);

        // Detach the connection type
        $request->user()->connections()->detach($request->connection_id);

        return redirect(route('user.setting.connections', absolute: false));
    }
}
