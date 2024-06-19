<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ResetPasswordModal } from '@/Components/features/auth';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <DefaultLayout>
        <Head title="Reset Password" />

        <ResetPasswordModal
            v-if="$page.props.data"
            :email="$page.props.data.email"
            :token="$page.props.data.token"
        />
    </DefaultLayout>
</template>
