<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Commands to ignore logging of start/stop points.
     *
     * @var array<string>
     */
    protected $ignored = [
        'db:seed',
        'dusk',
        'migrate',
        'migrate:fresh',
        'optimize:clear',
        'package:discover',
        'queue:work',
        'serve',
        'schedule:run',
        'schedule:work',
        'tinker',
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', 'on');
        }

        // Set differing password rules based on environment
        Password::defaults(function () {
            return $this->app->isProduction()
                ? Password::min(8)->mixedCase()->uncompromised()
                : Password::min(3);
        });

        // Monitor command state (starting)
        Event::listen(CommandStarting::class, function (CommandStarting $event) {
            if (! in_array($event->command, $this->ignored)) {
                Log::info(sprintf('[%s] Starting', $event->command));
            }
        });

        // Monitor command state (finished)
        Event::listen(CommandFinished::class, function (CommandFinished $event) {
            if (! in_array($event->command, $this->ignored)) {
                Log::info(sprintf('[%s] Finished', $event->command));
            }
        });

        if (! $this->app->environment('dusk')) {
            // Seed database on refreshes
            Event::listen(DatabaseRefreshed::class, function () {
                Artisan::call('db:seed');

                // Reset cached roles and permissions
                $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();
            });
        }
    }
}
