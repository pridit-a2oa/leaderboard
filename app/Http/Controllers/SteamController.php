<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\SteamConnectionMissingException;
use App\Models\Connection;
use App\Models\ConnectionUser;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use xPaw\Steam\SteamOpenID;

final class SteamController
{
    public function __invoke(): Response|RedirectResponse
    {
        $SteamOpenID = new SteamOpenID(url('/login'));

        if ($SteamOpenID->ShouldValidate()) {
            try {
                $steamId = $SteamOpenID->Validate();
            } catch (Exception $exception) {
                report($exception);

                return redirect(route('home', absolute: false));
            }
        } else {
            return Inertia::location(
                $SteamOpenID->GetAuthUrl()
            );
        }

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
