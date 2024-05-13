<script setup>
import { ref } from 'vue';
import SaveButton from '@/Components/SaveButton.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="submit">
            <label class="form-control">
                <div>
                    <label for="current_password" class="label !pt-0">
                        <span class="label-text">Current Password</span>
                    </label>

                    <TextInput
                        id="current_password"
                        type="password"
                        class="input input-bordered w-full"
                        ref="currentPasswordInput"
                        placeholder="&#9679;&#9679;&#9679;"
                        v-model="form.current_password"
                        required
                        autocomplete="current-password"
                        :error="form.errors.current_password"
                    />
                </div>

                <div class="mt-3">
                    <label for="password" class="label !pt-0">
                        <span class="label-text">New Password</span>
                    </label>

                    <TextInput
                        id="password"
                        type="password"
                        class="input input-bordered w-full"
                        placeholder="&#9679;&#9679;&#9679;"
                        v-model="form.password"
                        required
                        :error="form.errors.password"
                    />
                </div>

                <div class="mt-3">
                    <label for="password_confirmation" class="label !pt-0">
                        <span class="label-text">Confirm New Password</span>
                    </label>

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="input !input-bordered w-full"
                        placeholder="&#9679;&#9679;&#9679;"
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        required
                    />
                </div>

                <div class="mt-3 flex justify-end">
                    <SuccessMessage
                        v-if="form.wasSuccessful"
                        message="Password was changed"
                    />

                    <SaveButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </SaveButton>
                </div>
            </label>
        </form>
    </div>
</template>
