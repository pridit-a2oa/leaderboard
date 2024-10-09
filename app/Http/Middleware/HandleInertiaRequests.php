<?php

namespace App\Http\Middleware;

use App\Models\Mute;
use App\Models\User;
use App\Models\WebhookCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'app' => [
                'name' => config('app.title', config('app.name')),
                'statistics' => [
                    'mutes' => Auth::check() && $request->user()->hasRole('admin') ? Number::abbreviate(Mute::count()) : 0,
                    'users' => Auth::check() && $request->user()->hasRole('admin') ? Number::abbreviate(User::count()) : 0,
                    'webhooks' => Auth::check() && $request->user()->hasRole('admin') ? Number::abbreviate(WebhookCall::count()) : 0,
                ],
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'data' => fn () => $request->session()->get('data'),
                'message' => fn () => $request->session()->get('message') ?: [],
            ],
            'roles' => Auth::check() ? $request->user()->roles->pluck('name') : [],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
