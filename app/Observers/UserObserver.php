<?php

namespace App\Observers;

use App\Models\User;
use App\Events\Webhook\WebhookReset;
use App\Events\Webhook\WebhookRefresh;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // User changes email, so either associate or dissociate a contribution
        if ($user->wasChanged('email_verified_at')) {
            if ($user->contribution) {
                WebhookReset::dispatch($user);
            }

            WebhookRefresh::dispatch($user);
        }
    }
}
