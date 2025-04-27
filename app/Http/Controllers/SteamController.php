<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\SteamConnectionMissingException;
use App\Models\Connection;
use App\Models\ConnectionUser;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Ilzrv\LaravelSteamAuth\Exceptions\Authentication\SteamResponseNotValidAuthenticationException;
use Ilzrv\LaravelSteamAuth\Exceptions\Validation\ValidationException;
use Ilzrv\LaravelSteamAuth\SteamAuthenticator;
use Inertia\Inertia;
use JsonException;

final class SteamController
{
    public function __invoke(
        Request $request,
        Client $client,
        HttpFactory $httpFactory,
    ): Response|RedirectResponse {
        $steamAuthenticator = new SteamAuthenticator(
            new Uri($request->getUri()),
            $client,
            $httpFactory,
        );

        try {
            $steamAuthenticator->auth();
        } catch (
            ValidationException
            |SteamResponseNotValidAuthenticationException
            |JsonException
            $exception
        ) {
            report($exception);

            return Inertia::location(
                $steamAuthenticator->buildAuthUrl()
            );
        }

        $steamId = $steamAuthenticator->getSteamUser()->getSteamId();

        try {
            $connectionId = Connection::where('name', 'steam')->first()?->id;

            if (! $connectionId) {
                throw new SteamConnectionMissingException;
            }
        } catch (SteamConnectionMissingException $exception) {
            report($exception);

            return redirect(route('home', absolute: false));
        }

        $connection = ConnectionUser::where('connection_id', $connectionId)
            ->where('identifier', $steamId)
            ->first();

        $user = $connection
            ? $connection->user
            : tap(User::create(), function ($user) use ($connectionId, $steamId) {
                $user->connections()->attach(
                    $connectionId,
                    ['identifier' => $steamId]
                );
            });

        Auth::login($user, remember: true);

        return redirect(route('home', absolute: false));
    }
}
