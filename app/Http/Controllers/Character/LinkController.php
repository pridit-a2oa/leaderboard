<?php

namespace App\Http\Controllers\Character;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;

class LinkController extends Controller
{
    /**
     * Create a character link.
     */
    public function store(CharacterRequest $request): RedirectResponse
    {
        $request->validated();

        // Ineligible to link more than one character to a user as a member
        if (
            $request->user()->characters()->count() > 0
            && $request->user()->hasRole('member')
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
