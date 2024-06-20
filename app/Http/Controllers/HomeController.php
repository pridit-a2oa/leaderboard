<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
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
        return Inertia::render('Home', [
            'characters' => CharacterResource::collection(
                Character::with('statistics', 'user')
                    ->rankable()
                    ->paginate(50)
                    ->onEachSide(1)
            )->additional([
                'ranking' => Cache::get('ranking', []),
            ]),
        ]);
    }
}
