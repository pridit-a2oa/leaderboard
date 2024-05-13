<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Setting from '@/Components/Setting.vue';
import {
    UpdateEmailForm,
    UpdateNameForm,
    UpdatePasswordForm,
} from '@/Pages/Setting/Partials';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Account">
            <UpdateNameForm />

            <UpdateEmailForm />

            <UpdatePasswordForm />
        </Setting>
    </DefaultLayout>
</template>
