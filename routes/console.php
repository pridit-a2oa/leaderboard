<?php

use App\Console\Commands\CacheRanking;
use App\Console\Commands\ImportSteamAvatar;
use Illuminate\Support\Facades\Schedule;
use Propaganistas\LaravelDisposableEmail\Console\UpdateDisposableDomainsCommand;

Schedule::command(CacheRanking::class)->dailyAt('08:05');
Schedule::command(ImportSteamAvatar::class)->daily();
Schedule::command(UpdateDisposableDomainsCommand::class)->weekly();
