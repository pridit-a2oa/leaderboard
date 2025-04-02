<script setup>
import { UserSettings } from '@/Components/features/user';
import {
    UpdateEmailForm,
    UpdatePreferencesForm,
} from '@/Components/forms/complex';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings &#x2022; Account" />

    <UserSettings title="Account">
        <UpdateEmailForm />

        <!-- <UpdatePasswordForm /> -->

        <UpdatePreferencesForm v-if="$page.props.preferences.length > 0" />
    </UserSettings>
</template>
