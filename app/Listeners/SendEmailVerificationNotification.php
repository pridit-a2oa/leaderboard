<?php

namespace App\Listeners;

use App\Events\UserVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\RateLimiter;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(UserVerifyEmail $event): void
    {
        if ($event->user instanceof MustVerifyEmail) {
            RateLimiter::attempt(
                sprintf('verification-email:%d', $event->user->id),
                1,
                function () use ($event) {
                    if ($event->email !== $event->user->email) {
                        $event->user->newEmail($event->email);
                    } else {
                        $event->user->resendPendingEmailVerificationMail();
                    }
                },
                600
            );
        }
    }
}
