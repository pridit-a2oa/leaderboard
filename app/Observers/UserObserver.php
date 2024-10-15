<?php

namespace App\Observers;

use App\Events\Webhook\WebhookRefresh;
use App\Events\Webhook\WebhookReset;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->assignRole('member');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // User changes email, so either associate or dissociate a contribution
        if ($user->wasChanged('email_verified_at')) {
            if ($user->contribution && $user->hasRole('supporter')) {
                WebhookReset::dispatch($user);
            }

            WebhookRefresh::dispatch($user);
        }
    }
}
