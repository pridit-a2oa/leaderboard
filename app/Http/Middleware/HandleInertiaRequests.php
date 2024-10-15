<?php

namespace App\Http\Middleware;

use App\Models\Mute;
use App\Models\User;
use App\Models\WebhookCall;
use Illuminate\Http\Request;
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
            ],
            'auth' => [
                'model_counts' => [
                    'mutes' => $request->user()?->hasRole('admin') ? Number::abbreviate(Mute::count()) : null,
                    'users' => $request->user()?->hasRole('admin') ? Number::abbreviate(User::count()) : null,
                    'webhooks' => $request->user()?->hasRole('admin') ? Number::abbreviate(WebhookCall::count()) : null,
                ],
                'role' => $request->user()?->roles->value('name'),
                'user' => $request->user(),
            ],
            'flash' => [
                'data' => fn () => $request->session()->get('data'),
                'message' => fn () => $request->session()->get('message') ?: [],
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
