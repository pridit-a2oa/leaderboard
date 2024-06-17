<script setup>
import { ref } from 'vue';
import { LoginForm, RegistrationForm } from '@/Components/Form';
import Modal from '@/Components/Modal.vue';
import { faArrowRightLong } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const register = ref(false);
</script>

<template>
    <input id="modal" type="checkbox" class="modal-toggle" />

    <Modal v-if="$page.props.auth.user === null" @reset="register = false">
        <LoginForm v-if="!register" title="Sign in">
            <div class="pt-4 text-center text-sm">
                <span>No account?&nbsp;</span>

                <button class="underlined-link" @click="register = true">
                    Sign up<FontAwesomeIcon
                        class="ml-1 !align-middle"
                        :icon="faArrowRightLong"
                        size="xs"
                    />
                </button>
            </div>
        </LoginForm>

        <RegistrationForm v-else title="Sign up">
            <div class="pt-4 text-center text-sm">
                <span>Already registered?&nbsp;</span>

                <button class="underlined-link" @click="register = false">
                    Sign in<FontAwesomeIcon
                        class="ml-1 !align-middle"
                        :icon="faArrowRightLong"
                        size="xs"
                    />
                </button>
            </div>
        </RegistrationForm>
    </Modal>
</template>
