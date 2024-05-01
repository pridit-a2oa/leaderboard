<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Character;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(): Response
    {
        $characters = Character::rankable()
            ->orderByDesc('score')
            ->orderBy('updated_at')
            ->paginate(50)
            ->onEachSide(1)
            ->through(fn ($item) => [
                'id' => $item->id,
                'uid' => $item->uid,
                'name' => $item->name,
                'score' => $item->score,
                'last_seen' => $item->updated_at->diffForHumans()
            ]);

        return Inertia::render('Home', [
            'characters' => $characters
        ]);
    }
}
