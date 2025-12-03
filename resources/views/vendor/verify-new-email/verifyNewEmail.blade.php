@component('mail::message')
# Verify your email address

Please confirm that you want to use this email address with your account.

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

@component('mail::panel')
Or paste this link into your browser: {{ $url }}
@endcomponent

{{ config('app.name') }}
@endcomponent
