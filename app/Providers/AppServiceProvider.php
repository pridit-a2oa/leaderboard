<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
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
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule->mixedCase()->uncompromised()
                : $rule;
        });

        $ignored = [
            'db:seed',
            'dusk',
            'migrate',
            'migrate:fresh',
            'optimize:clear',
            'schedule:run',
            'schedule:work',
        ];

        // Monitor command state (starting)
        Event::listen(CommandStarting::class, function (CommandStarting $event) use ($ignored) {
            if (! in_array($event->command, $ignored)) {
                Log::info(sprintf('[%s] Starting', $event->command));
            }
        });

        // Monitor command state (finished)
        Event::listen(CommandFinished::class, function (CommandFinished $event) use ($ignored) {
            if (! in_array($event->command, $ignored)) {
                Log::info(sprintf('[%s] Finished', $event->command));
            }
        });
    }
}
