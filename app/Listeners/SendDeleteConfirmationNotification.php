<?php

namespace App\Listeners;

use App\Events\UserRequestDelete;
use App\Mail\DeleteUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendDeleteConfirmationNotification
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
    public function handle(UserRequestDelete $event): void
    {
        if ($event->user instanceof MustVerifyEmail && $event->user->hasVerifiedEmail()) {
            Mail::to($event->user)->queue(new DeleteUser($event->user));
        }
    }
}
