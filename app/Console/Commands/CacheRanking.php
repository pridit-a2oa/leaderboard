<?php

namespace App\Console\Commands;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:ranking';

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
        Cache::add(
            'ranking',
            Character::rankable()
                ->get()
                ->pluck('name')
                ->values()
                ->toArray()
        );
    }
}
