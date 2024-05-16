<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    /**
     * Get the page metadata to persist throughout settings.
     *
     * @return array<string, string>
     */
    protected function metadata(): array
    {
        return [
            'name' => 'Settings',
            'icon' => 'cog',
        ];
    }

    /**
     * Show the account page.
     */
    public function showAccount(Request $request): Response
    {
        return Inertia::render('Setting/Account', $this->metadata());
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
            'connections' => Connection::get()
                ->toArray(),
        ]
            + $this->metadata()
        );
    }

    /**
     * Show the features page, along with available features.
     */
    public function showFeatures(Request $request): Response
    {
        return Inertia::render('Setting/Features', [
            'features' => Statistic::orderBy('name')
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
