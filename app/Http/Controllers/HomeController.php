<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Character;
use App\Models\Statistic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index(): Response
    {
        $characters = Character::rankable()
            ->with('statistics')
            ->orderByDesc('score')
            ->paginate(50)
            ->onEachSide(1)
            ->through(fn ($item) => [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'uid' => $item->uid,
                'name' => $item->name,
                'score' => $item->score,
                'formatted_score' => $item->formatted_score,
                'is_visible' => $item->is_visible,
                'updated_at' => $item->updated_at,
                'statistics' => $item->statistics->toArray()
            ]);

        return Inertia::render('Home', [
            'characters' => $characters
        ]);
    }
}
