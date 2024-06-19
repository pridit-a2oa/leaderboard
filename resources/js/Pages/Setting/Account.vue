<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserSettings } from '@/Components/features/user';
import {
    UpdateEmailForm,
    UpdatePasswordForm,
} from '@/Components/forms/complex';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <UserSettings title="Account">
            <UpdateEmailForm :message="$page.props.flash.message" />

            <UpdatePasswordForm />
        </UserSettings>
    </DefaultLayout>
</template>
