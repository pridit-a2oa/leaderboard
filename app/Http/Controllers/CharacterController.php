<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CharacterRequest;
use Illuminate\Support\Facades\Redirect;

class CharacterController extends Controller
{
    /**
     * Link an authorised user with a character.
     */
    public function link(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Attach the character to the user
        auth()->user()->characters()->attach($character->id);

        return Redirect::route('home');
    }

    /**
     * Unlink an authorised user with a character.
     */
    public function unlink(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Reset the visibility of the character
        $character->is_visible = true;
        $character->save();

        // Detach the character from the user
        auth()->user()->characters()->detach($character->id);

        return Redirect::to('/settings/characters');
    }

    /**
     * Link an authorised user with a character.
     */
    public function toggleVisibility(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Toggle the visibility of the character
        $character->is_visible = !$character->is_visible;
        $character->save();

        return Redirect::to('/settings/characters');
    }
}
