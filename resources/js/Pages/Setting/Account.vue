<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserSettings } from '@/Components/features/user';
import {
    UpdateEmailForm,
    UpdatePasswordForm,
    UpdatePreferencesForm,
} from '@/Components/forms/complex';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings &#x2022; Account" />

    <DefaultLayout>
        <UserSettings title="Account">
            <UpdateEmailForm :message="$page.props.flash.message" />

            <UpdatePasswordForm />

            <UpdatePreferencesForm v-if="$page.props.preferences.length > 0" />
        </UserSettings>
    </DefaultLayout>
</template>
