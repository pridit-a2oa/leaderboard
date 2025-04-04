<?php

namespace App\Listeners;

use App\Events\UserDeleted;

class PruneUser
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(UserDeleted $event): void
    {
        $event->user->fill([
            'email' => null,
            'email_verified_at' => null,
            'delete_token' => null,
        ]);

        // Any linked characters can be relinked
        $event->user->characters()->update([
            'user_id' => null,
            'is_hidden' => false,
        ]);

        // Any contributions can be reassociated
        $event->user->contributions()->update(['user_id' => null]);

        // Remove user-centric relations
        $event->user->connections()->sync([]);
        $event->user->preferences()->sync([]);

        // Remove pending email change
        $event->user->clearPendingEmail();

        // Remove role
        $event->user->syncRoles();

        $event->user->save();
    }
}
