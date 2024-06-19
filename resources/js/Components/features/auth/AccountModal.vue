<script setup>
import { ref } from 'vue';
import { BaseModal } from '@/Components/base';
import { LoginForm, RegistrationForm } from '@/Components/features/auth';
import { faArrowRightLong } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const register = ref(false);
</script>

<template>
    <input id="modal" type="checkbox" class="modal-toggle" />

    <BaseModal v-if="$page.props.auth.user === null" @reset="register = false">
        <LoginForm v-if="!register" title="Sign in">
            <span>No account?&nbsp;</span>

            <button class="underlined-link" @click="register = true">
                Sign up<FontAwesomeIcon
                    class="ml-1 !align-middle"
                    :icon="faArrowRightLong"
                    size="xs"
                />
            </button>
        </LoginForm>

        <RegistrationForm v-else title="Sign up">
            <span>Already registered?&nbsp;</span>

            <button class="underlined-link" @click="register = false">
                Sign in<FontAwesomeIcon
                    class="ml-1 !align-middle"
                    :icon="faArrowRightLong"
                    size="xs"
                />
            </button>
        </RegistrationForm>
    </BaseModal>
</template>
