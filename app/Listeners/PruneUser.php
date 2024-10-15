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

        $user->fill([
            'email' => null,
            'email_verified_at' => null,
            'delete_token' => null,
        ]);

        // Linked characters are able to be relinked
        $user->characters()->update([
            'user_id' => null,
            'is_hidden' => false,
        ]);

        // Any third-party contribution can be reassociated
        if ($user->contribution) {
            $user->contribution->user_id = null;
            $user->contribution->save();
        }

        $user->connections()->sync([]);
        $user->preferences()->sync([]);

        // Remove pending email change
        $user->clearPendingEmail();

        // Remove role
        $user->syncRoles();

        $user->save();
    }
}
