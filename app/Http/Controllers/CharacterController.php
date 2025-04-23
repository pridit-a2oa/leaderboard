<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterFeatureRequest;
use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;

class CharacterController extends Controller
{
    /**
     * Link an authorised user with a character.
     */
    public function toggleVisibility(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Toggle the visibility of the character
        $character->is_hidden = ! $character->is_hidden;
        $character->save();

        return redirect()->back();
    }

    /**
     * Reset the statistics of a character.
     */
    public function reset(CharacterFeatureRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Remove all character statistics
        $character->statistics()->sync([]);

        return redirect()->back();
    }
}
