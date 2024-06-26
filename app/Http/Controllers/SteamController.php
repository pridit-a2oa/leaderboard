<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ConnectionUser;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Auth\AuthManager;
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

        $steamUser = $steamAuthenticator->getSteamUser();

        if (ConnectionUser::where('identifier', $steamUser->getSteamId())->doesntExist()) {
            Auth::user()->connections()->attach(
                1,
                ['identifier' => $steamUser->getSteamId()]
            );
        } else {
            $request->session()
                ->flash(
                    'message',
                    ['error', 'Steam account is already connected to a user']
                );
        }

        return redirect(route('user.setting.connections', absolute: false));
    }
}
