<?php

use App\Console\Commands\CacheRanking;
use App\Console\Commands\ImportSteamAvatar;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CacheRanking::class)->dailyAt('08:05');
Schedule::command(ImportSteamAvatar::class)->daily();
