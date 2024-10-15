<script setup>
import { ResetPasswordModal } from '@/Components/features/auth';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Reset Password" />

    <Teleport to="body">
        <ResetPasswordModal
            v-if="$page.props.data"
            :email="$page.props.data.email"
            :token="$page.props.data.token"
        />
    </Teleport>
</template>
