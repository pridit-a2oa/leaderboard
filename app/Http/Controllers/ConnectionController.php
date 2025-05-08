<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConnectionController extends Controller
{
    /**
     * Delete the user's connection.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'connection_id' => [
                'required',
                Rule::exists('connections', 'id')->where(function (Builder $query) {
                    $query->where('is_oauth', 0);
                })],
        ]);

        $connection = Connection::findOrFail($request->safe()->connection_id);

        // Unassociate all associated characters (Steam)
        if ($connection->name === 'steam') {
            $request->user()->characters()->update(['user_id' => null]);
        }

        // Detach the connection type
        $request->user()->connections()->detach($request->safe()->connection_id);

        return redirect(route('user.setting.connections', absolute: false));
    }
}
