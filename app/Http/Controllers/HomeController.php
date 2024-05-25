<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index(): Response
    {
        $characters = Character::rankable()
            ->with('user.roles', 'statistics')
            ->paginate(50)
            ->onEachSide(1)
            ->through(fn ($item) => [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'uid' => $item->uid,
                'name' => $item->name,
                'score' => $item->score,
                'formatted_score' => $item->formatted_score,
                'is_highest_score' => $item->is_highest_score,
                'last_seen_at' => $item->last_seen_at,
                'role' => $item->user ? $item->user->roles->first()->only('name') : [],
                'statistics' => $item->statistics->toArray(),
            ]);

        Cache::add(
            'ranking',
            Character::rankable()
                ->get()
                ->groupBy('name')
                ->keys()
                ->toArray(),
            now()->addDays(1)
        );

        return Inertia::render('Home', [
            'characters' => $characters,
            'ranking' => Cache::get('ranking') ?? [],
        ]);
    }
}
