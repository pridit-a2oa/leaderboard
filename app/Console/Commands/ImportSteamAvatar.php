<?php

namespace App\Console\Commands;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ImportSteamAvatar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:steam-avatar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'From the base64 of characters retrieve the subsequent Steam avatar URL, if missing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (empty(config('steam-auth.api_keys')[0])) {
            $this->fail('No Steam API key specified.');
        }

        Character::select('uid')
            ->missingAvatar()
            ->orderBy('uid')
            ->groupBy('uid')
            ->chunk(25, function (Collection $characters) {
                $response = Http::get(sprintf(
                    'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s',
                    config('steam-auth.api_keys')[0],
                    implode(',', $characters->pluck('uid')->toArray())
                ));

                if ($response->failed()) {
                    $this->fail('Steam API responded with an error.');
                }

                $response->collect('response.players')->each(function ($player) {
                    Character::where('uid', $player['steamid'])
                        ->update([
                            'avatar_url' => $player['avatar'],
                        ]);
                });
            });
    }
}
