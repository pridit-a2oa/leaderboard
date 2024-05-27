<?php

use App\Console\Commands\CacheRanking;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CacheRanking::class)->dailyAt('10:00');
