<?php

use App\Console\Commands\CacheRanking;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CacheRanking::class)->dailyAt('08:05');
