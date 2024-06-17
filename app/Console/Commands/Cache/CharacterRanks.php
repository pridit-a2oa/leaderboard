<?php

namespace App\Console\Commands\Cache;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CharacterRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:character-ranks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the current rank of characters to drive positional indicators';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear the existing cache
        if (Cache::has('ranking')) {
            Cache::forget('ranking');
        }

        Cache::add(
            'ranking',
            Character::rankable()
                ->get()
                ->pluck('id')
                ->values()
                ->toArray()
        );
    }
}
