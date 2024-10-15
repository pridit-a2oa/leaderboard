<script setup>
import { SuccessButton } from '@/Components/buttons';
import { FormInput, FormResponse } from '@/Components/forms/elements';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    message: {
        type: Array,
        default: [],
    },
});

const emailInput = ref(null);

let form = useForm({
    email: '',
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onError: () => emailInput.value.focus(),
        onSuccess: () => form.reset('email'),
    });
};
</script>

<template>
    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="submit">
            <label class="form-control">
                <div class="label !pt-0">
                    <span class="label-text">Email Address</span>

                    <span
                        class="badge badge-outline badge-sm"
                        :class="
                            $page.props.auth.user.email_verified_at !== null
                                ? 'badge-primary'
                                : 'badge-error'
                        "
                        >{{
                            $page.props.auth.user.email_verified_at !== null
                                ? 'V'
                                : 'Unv'
                        }}erified</span
                    >
                </div>

                <FormInput
                    id="email"
                    ref="emailInput"
                    type="name"
                    class="!border-transparent"
                    classes="!bg-base-100"
                    autocomplete="email"
                    required
                    v-model="form.email"
                    :error="form.errors.email"
                    :placeholder="$page.props.auth.user.email"
                />

                <div class="mt-3 flex justify-end">
                    <FormResponse
                        v-if="form.wasSuccessful || message.length > 0"
                        :message="
                            message.length > 0
                                ? message
                                : [
                                      'warning',
                                      'You have been sent a verification link',
                                  ]
                        "
                    />

                    <SuccessButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update
                    </SuccessButton>
                </div>
            </label>
        </form>
    </div>
</template>
