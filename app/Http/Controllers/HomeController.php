<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
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
            'filter' => ['sometimes', Rule::in(['all', 'active'])],
        ]);

        $characters = Character::with(['mute', 'statistics'])
            ->with(['user' => function ($query) {
                $query->without('connections');
            }])
            ->when(
                ! auth()->check()
                || ! auth()->user()->hasRole('admin')
                || (auth()->user()->hasRole('admin') && $request->query('filter') === 'active'),
                function (Builder $query) {
                    $query->rankable();
                })
            ->orderByDesc('score')
            ->orderBy('last_seen_at')
            ->paginate(25)
            ->onEachSide(1);

        if ($characters->isEmpty()) {
            $characters = Character::factory([
                'guid' => null,
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
                ])
            ),
            'filter' => $request->query('filter'),
        ]);
    }
}
