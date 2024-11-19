<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $request->validated();

        RateLimiter::attempt(
            sprintf('register:%s', $request->ip()),
            1,
            function () use ($request) {
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Auth::login($user);
            },
            600
        );

        return redirect(route('home', absolute: false));
    }
}
