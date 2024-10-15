<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * Update the user's preferences.
     */
    public function update(Request $request): RedirectResponse
    {
        $options = collect($request->all()['options'])
            ->mapWithKeys(function (bool $item, int $key) {
                return [$key => ['value' => $item]];
            });

        $request->user()->preferences()->syncWithoutDetaching(
            $options->toArray()
        );

        return back();
    }
}
