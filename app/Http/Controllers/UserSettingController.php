<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConnectionResource;
use App\Models\Connection;
use App\Models\Preference;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserSettingController extends SettingController
{
    /**
     * Show the account page.
     */
    public function showAccount(Request $request): Response
    {
        return Inertia::render('Setting/Account', [
            'preferences' => Preference::get(),
        ] + $this->metadata());
    }

    /**
     * Show the characters page.
     */
    public function showCharacters(Request $request): Response
    {
        return Inertia::render('Setting/Characters', $this->metadata());
    }

    /**
     * Show the connections page, along with available connections.
     */
    public function showConnections(Request $request): Response
    {
        return Inertia::render('Setting/Connections', [
            'connections' => ConnectionResource::collection(
                Connection::get()
            ),
        ]
            + $this->metadata()
        );
    }

    /**
     * Show the extras page, along with possible additional statistics.
     */
    public function showExtras(Request $request): Response
    {
        return Inertia::render('Setting/Extras', [
            'statistics' => Statistic::orderBy('name')
                ->get()
                ->pluck('name'),
        ]
            + $this->metadata()
        );
    }

    /**
     * Show the delete page.
     */
    public function showDelete(Request $request): Response
    {
        return Inertia::render('Setting/Delete', $this->metadata());
    }
}
