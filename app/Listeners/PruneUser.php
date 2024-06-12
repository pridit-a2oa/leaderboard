<?php

namespace App\Listeners;

use App\Events\UserDeleted;

class PruneUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserDeleted $event): void
    {
        $user = $event->user;

        // Nullify the user's relevant data
        $user->fill([
            'email' => null,
            'email_verified_at' => null,
            'delete_token' => null,
        ]);

        // Detach the user's character(s) and reset visibility
        $user->characters()->update([
            'user_id' => null,
            'is_hidden' => false,
        ]);

        // Detach the user's connection(s)
        $user->connections()->sync([]);

        // Dissociate the user's contribution
        if ($user->contribution) {
            $user->contribution->user_id = null;
            $user->contribution->save();
        }

        // Clear any pending email of the user
        $user->clearPendingEmail();

        // Delete the user's role
        $user->syncRoles();

        // Persist the changes
        $user->save();
    }
}
