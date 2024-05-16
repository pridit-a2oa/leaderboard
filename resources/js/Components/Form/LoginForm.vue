<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEnvelope, faKey } from '@fortawesome/free-solid-svg-icons';
import { useForm } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
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
                    autocomplete="current-password"
                />
            </label>

            <InputError class="mt-2" :message="form.errors.password" />

            <div class="mt-4 flex">
                <label class="label cursor-pointer">
                    <Checkbox
                        name="remember"
                        class="checkbox checkbox-xs mr-2 rounded-[0.3rem]"
                        v-model:checked="form.remember"
                    />

                    <span class="label-text">Remember me</span>
                </label>

                <a
                    class="underlined-link ml-auto content-center text-sm"
                    href="#"
                    >Lost Password?</a
                >
            </div>

            <button
                class="btn no-animation mt-4 w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Log in to your account
            </button>
        </div>
    </form>

    <slot />
</template>
