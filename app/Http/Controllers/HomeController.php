<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index(Request $request): Response
    {
        if (auth()->check()) {
            $request->user()->load('characters');
        }

        $request->validate([
            'filter' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    if (! auth()->check()) {
                        $fail('Must be authenticated to apply filtering.');
                    }

                    if (! in_array($value, ['active', 'me'])) {
                        $fail('Must be a valid selection to apply filtering.');
                    }
                },
            ],
        ]);

        $characters = Character::with(['mute', 'statistics'])
            ->with(['user' => function ($query) {
                $query->without('connections');
            }])
            ->rankable()
            ->orderByDesc('score')
            ->orderBy('last_seen_at')
            ->paginate(50)
            ->onEachSide(1);

        if ($characters->isEmpty()) {
            $characters = Character::factory([
                'id64' => null,
                'name' => 'Example',
            ])
                ->count(5)
                ->make()
                ->sortBy([
                    ['score', 'desc'],
                    ['last_seen_at', 'asc'],
                ]);
        }

        return Inertia::render('Home', [
            'characters' => Inertia::deepMerge($characters->toResourceCollection()
                ->additional([
                    'ranking' => Cache::get('ranking', []),
                    'total' => Character::count(),
                ])
            ),
            'filter' => $request->query('filter'),
        ]);
    }
}
