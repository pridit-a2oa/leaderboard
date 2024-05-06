<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterLinkRequest;

class CharacterController extends Controller
{
    /**
     * Link an authorised user with a character.
     */
    public function link(CharacterLinkRequest $request): Response
    {
        dd($request->validated());

        $user = $request->user();

        return Redirect::route('home');
    }
}
