<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;
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

        if (Character::count() > 0) {
            $characters = Character::with(['mute', 'statistics'])
                ->with(['user' => function ($query) {
                    $query->without('connections');
                }])
                ->when(! auth()->check() || ! auth()->user()->hasRole('admin'), function (Builder $query) {
                    $query->rankable();
                })
                ->orderByDesc('score')
                ->orderBy('last_seen_at')
                ->paginate(50)
                ->onEachSide(1);
        } else {
            $characters = Character::factory([
                'guid' => null,
                'name' => 'Example',
            ])
                ->count(5)
                ->make()
                ->sortBy('last_seen_at')
                ->sortByDesc('score');
        }

        return Inertia::render('Home', [
            'characters' => CharacterResource::collection($characters)
                ->additional([
                    'ranking' => Cache::get('ranking', []),
                ]),
        ]);
    }
}
