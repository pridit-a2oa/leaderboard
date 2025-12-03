<x-mail::message>
# Delete your account

This message confirms that we've received your request to delete your account. Once the deletion is complete, all associated data will be permanently removed and cannot be recovered.

Use the button below to process the deletion. This will expire in 1 hour.

<x-mail::button :url="$url">
Delete Account
</x-mail::button>

<x-mail::panel>
Or paste this link into your browser: {{ $url }}
</x-mail::panel>

{{ config('app.name') }}
</x-mail::message>
