<?php

use App\Console\Commands\Cache\CharacterRanks;
use App\Console\Commands\Import\SteamAvatars;
use Illuminate\Support\Facades\Schedule;
use Propaganistas\LaravelDisposableEmail\Console\UpdateDisposableDomainsCommand;

/**
 * Application
 */
Schedule::command(CharacterRanks::class)
    ->dailyAt('08:05');

Schedule::command(SteamAvatars::class)
    ->daily()
    ->skip(function () {
        return now()->isSameDay(now()->startOfMonth());
    });

Schedule::command(SteamAvatars::class, ['--force'])
    ->monthly();

/**
 * Vendor
 */
Schedule::command(UpdateDisposableDomainsCommand::class)
    ->weekly();
