<script setup>
import { BaseModal } from '@/Components/base';
import { PasswordResetForm } from '@/Components/features/auth';
</script>

<template>
    <BaseModal class="modal-open">
        <PasswordResetForm title="Reset Password" v-bind="$attrs" />
    </BaseModal>
</template>
