<?php

namespace App\Console\Commands\Import;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SteamAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:steam-avatars {--F|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Using the uid of characters missing an avatar, retrieve the subsequent non-default Steam avatar URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (empty(config('steam-auth.api_keys')[0])) {
            $this->fail('No Steam API key specified.');
        }

        Character::when(! $this->option('force'), function (Builder $query) {
            $query->missingAvatar();
        })->chunkById(25, function (Collection $characters) {
            $response = Http::get(sprintf(
                'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s',
                config('steam-auth.api_keys')[0],
                implode(',', $characters->pluck('uid')->toArray())
            ));

            if ($response->failed()) {
                $this->fail('Steam API responded with an error.');
            }

            $response->collect('response.players')->each(function ($player) {
                // Ignore default avatar
                if ($player['avatar'] === 'https://avatars.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb.jpg') {
                    return;
                }

                Character::where('uid', $player['steamid'])
                    ->update([
                        'avatar_url' => $player['avatarmedium'],
                    ]);
            });
        });
    }
}
