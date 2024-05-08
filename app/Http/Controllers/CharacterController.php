<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CharacterController extends Controller
{
    /**
     * Link an authorised user with a character.
     */
    public function link(Request $request): RedirectResponse
    {
        $request->validate([
            'character_id' => ['required', 'exists:characters,id'],
        ]);

        $character = Character::findOrFail($request->character_id);

        if (in_array(
            $character->uid,
            auth()->user()->connections()->pluck('identifier')->all()
        )) {
            auth()->user()->characters()->attach($character->id);
        }

        return Redirect::route('home');
    }
}
