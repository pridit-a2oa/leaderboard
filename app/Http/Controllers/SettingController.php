<?php

namespace App\Http\Controllers;

use App\Models\Mute;
use App\Models\User;
use App\Models\WebhookCall;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request)
    {
        Inertia::share([
            'model_counts' => [
                'characters' => $request->user() ? Number::abbreviate(max($request->user()?->characters->count(), 0)) : null,
                'mutes' => $request->user()?->hasRole('admin') ? Number::abbreviate(Mute::count()) : null,
                'users' => $request->user()?->hasRole('admin') ? Number::abbreviate(User::count()) : null,
                'webhooks' => $request->user()?->hasRole('admin') ? Number::abbreviate(WebhookCall::count()) : null,
            ],
        ]);
    }

    /**
     * Get the page metadata to persist throughout settings.
     *
     * @return array<string, string>
     */
    protected function metadata(): array
    {
        return [
            'name' => 'Settings',
            'icon' => 'bars',
        ];
    }
}
