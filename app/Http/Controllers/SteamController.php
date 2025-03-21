<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ConnectionUser;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Ilzrv\LaravelSteamAuth\Exceptions\Authentication\SteamResponseNotValidAuthenticationException;
use Ilzrv\LaravelSteamAuth\Exceptions\Validation\ValidationException;
use Ilzrv\LaravelSteamAuth\SteamAuthenticator;
use Inertia\Inertia;

final class SteamController
{
    public function __invoke(
        Request $request,
        Client $client,
        HttpFactory $httpFactory,
        AuthManager $authManager,
    ): Response|RedirectResponse {
        $steamAuthenticator = new SteamAuthenticator(
            new Uri($request->getUri()),
            $client,
            $httpFactory,
        );

        try {
            $steamAuthenticator->auth();
        } catch (ValidationException|SteamResponseNotValidAuthenticationException) {
            return Inertia::location(
                $steamAuthenticator->buildAuthUrl()
            );
        }

        $steamIdentifier = $steamAuthenticator->getSteamUser()->getSteamId();

        if (ConnectionUser::where('identifier', $steamIdentifier)->doesntExist()) {
            $user = User::create();

            $user->connections()->attach(
                1,
                ['identifier' => $steamIdentifier]
            );
        } else {
            $user = User::whereHas('connections', function (Builder $query) use ($steamIdentifier) {
                $query->where('connection_id', 1)->where('identifier', $steamIdentifier);
            })->first();
        }

        Auth::login($user, true);

        return redirect(route('home', absolute: false));
    }
}
