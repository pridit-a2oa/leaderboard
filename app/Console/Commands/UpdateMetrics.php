<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\Metric;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update metrics to drive the admin dashboard (e.g. new/returning players)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = Carbon::now()->subMinute(10)->startOfDay();
        $end = Carbon::now()->subMinute(10)->endOfDay();

        collect([
            [
                'key' => 'player-returning',
                'value' => Character::whereBetween('last_seen_at', [$start, $end])
                    ->whereNotBetween('created_at', [$start, $end])->count(),
            ],
            [
                'key' => 'player-new',
                'value' => Character::whereBetween('created_at', [$start, $end])->count(),
            ],
        ])->each(function ($metric) use ($start) {
            Metric::updateOrCreate([
                'key' => $metric['key'],
                'created_at' => $start,
            ], [
                'value' => $metric['value'],
            ]);
        });
    }
}
