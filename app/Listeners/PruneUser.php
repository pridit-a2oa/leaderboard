<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            'name' => null,
            'email' => null,
            'email_verified_at' => null
        ]);

        // Detach the user's character(s)
        $user->characters()->detach();

        // Detach the user's connection(s)
        $user->connections()->detach();

        // Dissociate the user's contribution
        $user->contribution()->dissociate();

        // Delete the user's role
        $user->syncRoles();

        // Persist the changes
        $user->save();
    }
}
