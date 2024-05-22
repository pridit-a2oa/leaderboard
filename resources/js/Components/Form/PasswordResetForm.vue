<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { faKey, faEnvelope } from '@fortawesome/free-solid-svg-icons';
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
            <label
                class="input input-bordered mt-4 flex items-center gap-2 bg-base-200"
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faEnvelope"
                    size="xs"
                    fixed-width
                />

                <TextInput
                    id="email"
                    type="email"
                    class="!border-transparent"
                    placeholder="Email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    readonly
                />
            </label>

            <InputError class="mt-2" :message="form.errors.email" />

            <label
                class="input input-bordered mt-4 flex items-center gap-2 bg-base-200"
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faKey"
                    size="xs"
                    fixed-width
                />

                <TextInput
                    id="password"
                    type="password"
                    class="!border-transparent"
                    v-model="form.password"
                    placeholder="New Password"
                    required
                />
            </label>

            <InputError class="mt-2" :message="form.errors.password" />

            <label
                class="input input-bordered mt-4 flex items-center gap-2 bg-base-200"
            >
                <FontAwesomeIcon
                    class="text-neutral-400"
                    :icon="faKey"
                    size="xs"
                    fixed-width
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="!border-transparent"
                    v-model="form.password_confirmation"
                    placeholder="Confirm New Password"
                    required
                />
            </label>

            <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
            />

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
