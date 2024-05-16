<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
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
    public function handle(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->newEmail($event->user->email);
        }
    }
}
