<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // User creates account (check Ko-fi contribution)
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // User updates email_verified_at (check Ko-fi contribution)
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // User (soft) deletes account (unassociate Ko-fi contribution, plus the
        // other cleanup stuff for relations)
    }
}
