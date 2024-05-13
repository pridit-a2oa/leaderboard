<script setup>
import { ref, computed } from 'vue';
import SaveButton from '@/Components/SaveButton.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    verified: {
        type: Boolean,
        default: false,
    },
});

const message = computed(() => {
    return props.verified
        ? 'Your new email address was verified'
        : 'You have been sent a verification link';
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
                        class="badge badge-outline label-text badge-sm"
                        :class="
                            $page.props.auth.user.email_verified_at !== null
                                ? 'badge-success'
                                : 'badge-error'
                        "
                        >{{
                            $page.props.auth.user.email_verified_at !== null
                                ? 'V'
                                : 'Unv'
                        }}erified</span
                    >
                </div>

                <TextInput
                    id="email"
                    ref="emailInput"
                    type="name"
                    class="input input-bordered"
                    autocomplete="email"
                    required
                    v-model="form.email"
                    :error="form.errors.email"
                    :placeholder="$page.props.auth.user.email"
                />

                <div class="mt-3 flex justify-end">
                    <SuccessMessage
                        v-if="form.wasSuccessful || verified"
                        :message="message"
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
