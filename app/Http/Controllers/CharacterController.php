<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CharacterRequest;
use App\Http\Requests\CharacterFeatureRequest;

class CharacterController extends Controller
{
    /**
     * Link an authorised user with a character.
     */
    public function link(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Ineligible to link more than one character to a user as a member
        if (auth()->user()->characters()->count() > 0 && auth()->user()->hasRole('member')) {
            return redirect(route('home', absolute: false));
        }

        // Attach the character to the user
        $character->user()->associate(auth()->user()->id);
        $character->save();

        return redirect(route('home', absolute: false));
    }

    /**
     * Unlink an authorised user with a character.
     */
    public function unlink(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Dissociate the user from the character
        $character->user()->dissociate();

        // Reset the visibility of the character
        $character->is_visible = true;
        $character->save();

        return redirect()->back();
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

        return redirect()->back();
    }

    /**
     * Reset the statistics of a character.
     */
    public function reset(CharacterFeatureRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Zero the score of the character
        $character->score = 0;
        $character->save();

        // Detach all character statistics
        $character->statistics()->detach();

        return redirect()->back();
    }
}
