<?php

namespace App\Listeners\Contribution;

use App\Models\User;
use App\Models\Contribution;
use App\Events\Webhook\WebhookRefresh;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssociateContribution
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
    public function handle(WebhookRefresh $event): void
    {
        // Find a contribution from the user email
        $contribution = Contribution::where('email', $event->user->email)->first();

        // No contribution was found
        if (!$contribution) return;

        // Associate the contribution to the user
        $contribution->user()->associate($event->user->id);
        $contribution->save();

        // Assign supporter role
        $event->user->syncRoles('supporter');
    }
}
