<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Delete the user's account.
     */
    public function delete(Request $request): RedirectResponse
    {
        $request->session()->flash('message', 'Please check your email for a confirmation link');

        return Redirect::to('/settings/delete');
    }
}
