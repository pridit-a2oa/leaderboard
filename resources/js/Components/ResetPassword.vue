<script setup>
import { PasswordResetForm } from '@/Components/Form';
import Modal from '@/Components/Modal.vue';

defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Modal class="modal-open">
        <PasswordResetForm
            title="Reset Password"
            :email="email"
            :token="token"
        />
    </Modal>
</template>
