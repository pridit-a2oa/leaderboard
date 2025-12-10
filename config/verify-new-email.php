<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Verification Route
    |--------------------------------------------------------------------------
    |
    | The name of the route that handles the email verification process.
    |
    */

    'route' => 'verification.verify',

    /*
    |--------------------------------------------------------------------------
    | Post-Verification Redirect
    |--------------------------------------------------------------------------
    |
    | The path the user should be redirected to after completing verification.
    |
    */

    'redirect_to' => '/settings/account',

    /*
    |--------------------------------------------------------------------------
    | Auto-Login After Verification
    |--------------------------------------------------------------------------
    |
    | Indicates whether the user should be logged in automatically after their
    | email address has been successfully verified.
    |
    */

    'login_after_verification' => true,

    /*
    |--------------------------------------------------------------------------
    | Remember User
    |--------------------------------------------------------------------------
    |
    | Determines whether the user should be permanently remembered after login.
    |
    */

    'login_remember' => false,

    /*
    |--------------------------------------------------------------------------
    | Token Model
    |--------------------------------------------------------------------------
    |
    | The model responsible for storing and retrieving pending email tokens.
    |
    */

    'model' => \ProtoneMedia\LaravelVerifyNewEmail\PendingUserEmail::class,

    /*
    |--------------------------------------------------------------------------
    | First Email Verification Mailable
    |--------------------------------------------------------------------------
    |
    | The mailable sent when verifying the user's initial email address used
    | during registration.
    |
    */

    'mailable_for_first_verification' => \ProtoneMedia\LaravelVerifyNewEmail\Mail\VerifyFirstEmail::class,

    /*
    |--------------------------------------------------------------------------
    | New Email Verification Mailable
    |--------------------------------------------------------------------------
    |
    | The mailable sent when verifying a newly requested email address,
    | such as during an email update.
    |
    */

    'mailable_for_new_email' => \ProtoneMedia\LaravelVerifyNewEmail\Mail\VerifyNewEmail::class,

];
