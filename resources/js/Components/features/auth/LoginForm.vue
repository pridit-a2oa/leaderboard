<script setup>
import { ref } from 'vue';
import { FormCheckbox, FormInput } from '@/Components/forms/elements';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEnvelope, faKey } from '@fortawesome/free-solid-svg-icons';
import { useForm } from '@inertiajs/vue3';

const emailInput = ref(null);
const passwordInput = ref(null);

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

const login = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const reset = () => {
    form.post(route('password.email'), {
        onError: () => emailInput.value.focus(),
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <h2 class="text-lg font-bold">{{ title }}</h2>

    <form @submit.prevent="" @keydown.enter="$event.preventDefault()">
        <div class="form-control">
            <FormInput
                id="email"
                ref="emailInput"
                type="email"
                class="!border-transparent"
                classes="mt-4"
                placeholder="Email"
                :error="form.errors.email"
                v-model="form.email"
                required
                autocomplete="email"
            >
                <FontAwesomeIcon
                    class="text-neutral-500"
                    :icon="faEnvelope"
                    size="sm"
                />
            </FormInput>

            <FormInput
                id="password"
                ref="passwordInput"
                type="password"
                class="!border-transparent"
                classes="mt-4"
                :error="form.errors.password"
                v-model="form.password"
                placeholder="Password"
                autocomplete="current-password"
            >
                <FontAwesomeIcon
                    class="text-neutral-500"
                    :icon="faKey"
                    size="sm"
                />
            </FormInput>

            <div class="mt-4 flex">
                <FormCheckbox
                    name="remember"
                    :message="form.errors.conditions"
                    v-model:checked="form.remember"
                >
                    Keep me signed in
                </FormCheckbox>

                <button
                    class="underlined-link ml-auto content-center text-sm"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="reset"
                >
                    Lost Password?
                </button>
            </div>

            <button
                class="no-animation btn mt-4 w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="login"
            >
                Sign in to your account
            </button>
        </div>
    </form>

    <div class="mt-4 self-center">
        <slot />
    </div>
</template>
