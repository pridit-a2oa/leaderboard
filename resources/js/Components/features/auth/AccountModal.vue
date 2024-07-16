<script setup>
import { ref } from 'vue';
import { BaseModal } from '@/Components/base';
import { LinkButton } from '@/Components/buttons';
import { LoginForm, RegistrationForm } from '@/Components/features/auth';

const register = ref(false);
</script>

<template>
    <BaseModal
        v-if="$page.props.auth.user === null"
        id="account-modal"
        @reset="register = false"
    >
        <LoginForm v-if="!register" title="Sign in">
            <span>No account?&nbsp;</span>

            <LinkButton @click="register = true">Sign up</LinkButton>
        </LoginForm>

        <RegistrationForm v-else title="Sign up">
            <span>Already registered?&nbsp;</span>

            <LinkButton @click="register = false">Sign in</LinkButton>
        </RegistrationForm>
    </BaseModal>
</template>
