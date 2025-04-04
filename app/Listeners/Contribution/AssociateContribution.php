<?php

namespace App\Listeners\Contribution;

use App\Events\Webhook\WebhookRefresh;
use App\Models\Contribution;

class AssociateContribution
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(WebhookRefresh $event): void
    {
        // Associate any contributions to the user
        $contributions = Contribution::where('email', $event->user->email)
            ->update([
                'user_id' => $event->user->id,
            ]);

        // No contributions were associated, nothing to do
        if ($contributions === 0) {
            return;
        }

        // Assign supporter role
        $event->user->syncRoles('supporter');
    }
}
