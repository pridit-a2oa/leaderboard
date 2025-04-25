<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;

class CharacterLinkController extends Controller
{
    /**
     * Create a character link.
     */
    public function store(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        // Ineligible to associate more than one character as a member
        if (
            $request->user()->hasRole('member')
            && $request->user()->characters()->exists()
        ) {
            return back();
        }

        $character = Character::findOrFail($request->character_id);

        // Attach the character to the user
        $character->user()->associate($request->user()->id);
        $character->save();

        return back();
    }

    /**
     * Delete the character link.
     */
    public function destroy(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        $character = Character::findOrFail($request->character_id);

        // Dissociate the user from the character
        $character->user()->dissociate();

        // Reset the visibility of the character
        $character->is_hidden = false;
        $character->save();

        return back();
    }
}
