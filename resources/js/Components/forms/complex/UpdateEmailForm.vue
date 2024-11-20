<script setup>
import { BaseButton } from '@/Components/base';
import { FormInput, FormResponse } from '@/Components/forms/elements';
import { faRotateRight } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { router, useForm } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import { onBeforeUnmount, ref } from 'vue';

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
        onStart: () => reset(),
        onError: () => emailInput.value.focus(),
        onSuccess: () => form.reset('email'),
    });
};

const timeout = ref(null);

const resend = throttle(() => {
    timeout.value = setTimeout(() => router.get('/resend-email'), 1800);
}, 2000);

onBeforeUnmount(() => {
    reset();
});

function reset() {
    resend.cancel();

    clearTimeout(timeout.value);

    timeout.value = null;
}
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
                                ? 'badge-success'
                                : 'badge-warning'
                        "
                        >{{
                            $page.props.auth.user.email_verified_at !== null
                                ? 'V'
                                : 'Unv'
                        }}erified
                        <span
                            v-if="
                                $page.props.auth.user.email_verified_at === null
                            "
                            class="ml-1 cursor-pointer border-l border-warning pl-1"
                            :class="{
                                '!cursor-not-allowed':
                                    $page.props.auth.user
                                        .is_verification_email_throttled,
                            }"
                            :title="
                                (!$page.props.auth.user
                                    .is_verification_email_throttled &&
                                    'Resend verification email') ||
                                'Please try again later'
                            "
                            v-on="
                                !$page.props.auth.user
                                    .is_verification_email_throttled
                                    ? { click: resend }
                                    : {}
                            "
                        >
                            <FontAwesomeIcon
                                :class="{
                                    'fa-spin': timeout,
                                    'opacity-40':
                                        $page.props.auth.user
                                            .is_verification_email_throttled,
                                }"
                                :icon="faRotateRight"
                                transform="shrink-2"
                            />
                        </span>
                    </span>
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
                                      'Check your email for a verification link',
                                  ]
                        "
                    />

                    <BaseButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update
                    </BaseButton>
                </div>
            </label>
        </form>
    </div>
</template>
