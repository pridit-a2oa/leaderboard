@component('mail::message')
# Delete Account Confirmation

Please click the button below to proceed with your account deletion.

@component('mail::button', ['url' => $url])
Delete Account
@endcomponent

This deletion confirmation link will expire in 60 minutes.

If you did not make this request please change your password immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
