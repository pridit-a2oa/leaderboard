<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faUser, faEnvelope, faKey } from '@fortawesome/free-solid-svg-icons';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    conditions: false,
});

const submit = () => {
    form.post(route('register'), {
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
                    :icon="faUser"
                    size="xs"
                    fixed-width
                />

                <TextInput
                    id="name"
                    type="text"
                    class="!border-transparent"
                    placeholder="Nickname"
                    v-model="form.name"
                    required
                />
            </label>

            <InputError class="mt-2" :message="form.errors.name" />

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
                    placeholder="Password"
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
                    placeholder="Confirm Password"
                    required
                />
            </label>

            <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
            />

            <div class="mt-4 flex">
                <label class="label cursor-pointer">
                    <Checkbox
                        name="conditions"
                        class="checkbox checkbox-xs mr-2 rounded-[0.3rem]"
                        v-model:checked="form.conditions"
                        required
                    />

                    <span class="label-text"
                        >I agree to the
                        <a
                            class="underlined-link"
                            :href="route('terms')"
                            target="_blank"
                            >Terms of Use</a
                        >
                        &
                        <a
                            class="underlined-link"
                            :href="route('privacy')"
                            target="_blank"
                            >Privacy Policy</a
                        ></span
                    >
                </label>
            </div>

            <InputError class="mt-2" :message="form.errors.conditions" />

            <button
                class="btn no-animation mt-4 w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Register an account
            </button>
        </div>
    </form>

    <slot />
</template>
