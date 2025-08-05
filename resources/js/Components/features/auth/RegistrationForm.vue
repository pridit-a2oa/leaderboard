<script setup>
import { FormCheckbox, FormInput } from '@/Components/forms/elements';
import { faEnvelope, faKey } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from 'laravel-precognition-vue-inertia';

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const form = useForm('post', route('register'), {
    email: '',
    password: '',
    password_confirmation: '',
    conditions: false,
});

const submit = () =>
    form.submit({
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
</script>

<template>
    <h2 class="text-lg font-bold">{{ title }}</h2>

    <form @submit.prevent="submit">
        <div class="form-control">
            <FormInput
                id="email"
                type="email"
                class="!border-transparent"
                classes="mt-4"
                placeholder="Email"
                :error="form.errors.email"
                v-model="form.email"
                required
                @blur="form.validate('email')"
            >
                <FontAwesomeIcon
                    class="text-neutral-500"
                    :icon="faEnvelope"
                    size="sm"
                />
            </FormInput>

            <FormInput
                id="password"
                type="password"
                class="!border-transparent"
                classes="mt-4"
                :error="form.errors.password"
                v-model="form.password"
                placeholder="Password"
                required
                @blur="form.validate('password')"
            >
                <FontAwesomeIcon
                    class="text-neutral-500"
                    :icon="faKey"
                    size="sm"
                />
            </FormInput>

            <FormInput
                id="password_confirmation"
                type="password"
                class="!border-transparent"
                classes="mt-4"
                :error="form.errors.password_confirmation"
                v-model="form.password_confirmation"
                placeholder="Confirm Password"
                required
            >
                <FontAwesomeIcon
                    class="text-neutral-500"
                    :icon="faKey"
                    size="sm"
                />
            </FormInput>

            <div class="mt-4 flex">
                <FormCheckbox
                    name="conditions"
                    :error="form.errors.conditions"
                    v-model:checked="form.conditions"
                    required
                >
                    <span class="ml-0.5 block text-xs"
                        >I confirm that I am at least 18 years old and agree to
                        the
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
                        >.</span
                    >
                </FormCheckbox>
            </div>

            <button
                class="btn no-animation mt-4 w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing || form.hasErrors"
            >
                Create account
            </button>
        </div>
    </form>

    <div class="mt-4 self-center">
        <slot />
    </div>
</template>
