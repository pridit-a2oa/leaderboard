<?php

namespace App\Listeners\Contribution;

use App\Events\Webhook\WebhookReset;

class DissociateContribution
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(WebhookReset $event): void
    {
        // User does not have any contributions, nothing to do
        if ($event->user->contributions->count() === 0) {
            return;
        }

        // Dissociate any contributions
        $event->user->contributions()->update(['user_id' => null]);

        // Revert the user back to a member
        $event->user->syncRoles('member');
    }
}
