<script setup>
import { FormInput } from '@/Components/forms/elements';
import { useForm } from '@inertiajs/vue3';
import { faEnvelope, faKey } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <h2 class="text-lg font-bold">{{ title }}</h2>

    <form @submit.prevent="submit">
        <div class="form-control">
            <FormInput
                id="reset-email"
                type="email"
                class="!border-transparent"
                classes="input input-bordered mt-4"
                placeholder="Email"
                :error="form.errors.email"
                v-model="form.email"
                required
                autocomplete="email"
                readonly
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faEnvelope"
                    size="xs"
                    fixed-width
                />
            </FormInput>

            <FormInput
                id="reset-password"
                type="password"
                class="!border-transparent"
                classes="input input-bordered mt-4"
                :error="form.errors.password"
                v-model="form.password"
                placeholder="New Password"
                required
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faKey"
                    size="xs"
                    fixed-width
                />
            </FormInput>

            <FormInput
                id="reset-password_confirmation"
                type="password"
                class="!border-transparent"
                classes="input input-bordered mt-4"
                :error="form.errors.password_confirmation"
                v-model="form.password_confirmation"
                placeholder="Confirm New Password"
                required
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faKey"
                    size="xs"
                    fixed-width
                />
            </FormInput>

            <button
                class="btn no-animation mt-4 w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Reset Password
            </button>
        </div>
    </form>
</template>
