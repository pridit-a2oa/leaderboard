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
            ->orderBy('updated_at')
            ->paginate(50)
            ->onEachSide(1);

        return Inertia::render('Home', [
            'characters' => $characters
        ]);
    }

    /**
     * Show the privacy policy page.
     */
    public function privacy(): Response
    {
        return Inertia::render('Privacy', [
            'name' => 'Privacy Policy',
            'icon' => 'file'
        ]);
    }
}
