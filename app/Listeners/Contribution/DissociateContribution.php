<?php

namespace App\Listeners\Contribution;

use App\Models\User;
use App\Models\Contribution;
use App\Events\Webhook\WebhookReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DissociateContribution
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
    public function handle(WebhookReset $event): void
    {
        $user = $event->user;

        // User does not have a contribution
        if (!$user->contribution) return;

        // Dissociate the user's contribution, making it valid for re-use
        $user->contribution->user_id = null;
        $user->contribution->save();

        // Revert the user back to a member
        $user->syncRoles('member');
    }
}