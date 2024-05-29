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
                'uid' => ! $item->is_hidden ? $item->uid : '',
                'name' => ! $item->is_hidden ? $item->name : 'Anonymous',
                'score' => $item->score,
                'formatted_score' => $item->formatted_score,
                'is_hidden' => $item->is_hidden,
                'is_highest_score' => $item->user ? $item->is_highest_score : false,
                'formatted_last_seen_at' => ! $item->is_hidden ? $item->formatted_last_seen_at : 'N/A',
                'role' => $item->user ? $item->user->roles->first()->only('name') : [],
                'statistics' => ! $item->is_hidden ? $item->statistics->toArray() : [],
            ]);

        return Inertia::render('Home', [
            'characters' => $characters,
            'ranking' => Cache::get('ranking', []),
        ]);
    }
}
