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
        $characters = Character::orderByDesc('score')
            ->paginate(50)
            ->through(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'score' => $item->score
            ]);

        return Inertia::render('Home', [
            'characters' => $characters
        ]);
    }
}
