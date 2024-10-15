<script setup>
import { BaseModal } from '@/Components/base';
import { PasswordResetForm } from '@/Components/features/auth';
</script>

<template>
    <BaseModal :checked="true">
        <PasswordResetForm title="Reset Password" v-bind="$attrs" />
    </BaseModal>
</template>
