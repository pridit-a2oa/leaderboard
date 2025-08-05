<script setup>
import { BaseButton } from '@/Components/base';
import { FormInput, FormResponse } from '@/Components/forms/elements';
import { faRotateRight } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { router, usePage, usePoll } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import throttle from 'lodash/throttle';
import { onBeforeUnmount, ref, watch } from 'vue';

const email = ref(null);
const timeout = ref(null);

const form = useForm('patch', route('profile.update'), {
    email: '',
});

if (usePage().props.auth.user.email_verified_at === null) {
    const { start, stop } = usePoll(
        5000,
        {},
        {
            autoStart:
                usePage().props.auth.user.is_verification_email_throttled,
        },
    );

    watch(
        () => usePage().props.auth.user.is_verification_email_throttled,
        (isThrottled) => {
            if (!isThrottled) {
                stop();
            } else {
                start();
            }
        },
        { immediate: true },
    );
}

const submit = () =>
    form.submit({
        preserveScroll: true,
        onStart: () => reset(),
        onError: () => email.value.focus(),
        onSuccess: () => form.reset('email'),
    });

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
    <div class="bg-base-200 rounded-md p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="submit">
            <label class="form-control">
                <div class="label w-full !pt-0">
                    <span class="label-text">Email Address</span>

                    <span
                        v-if="$page.props.auth.user.email"
                        class="badge badge-outline badge-sm ml-auto"
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
                            class="border-l pl-1.5"
                        >
                            <span
                                class="border-warning cursor-pointer"
                                :class="{
                                    '!cursor-not-allowed':
                                        $page.props.auth.user
                                            .is_verification_email_throttled,
                                }"
                                :title="
                                    (!$page.props.auth.user
                                        .is_verification_email_throttled &&
                                        'Resend verification email') ||
                                    'Too soon to resend, please try again later'
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
                                        'loading-bars loading mt-1': timeout,
                                        'opacity-40':
                                            $page.props.auth.user
                                                .is_verification_email_throttled,
                                    }"
                                    :icon="faRotateRight"
                                    transform="down-1 shrink-1"
                                />
                            </span>
                        </span>
                    </span>
                </div>

                <FormInput
                    id="email"
                    ref="email"
                    type="email"
                    class="!border-transparent"
                    classes="!bg-base-100"
                    autocomplete="email"
                    required
                    v-model="form.email"
                    :error="form.errors.email"
                    :placeholder="$page.props.auth.user.email ?? 'None Set'"
                    @blur="form.validate('email')"
                />

                <div class="mt-3 flex justify-end">
                    <FormResponse
                        v-if="form.wasSuccessful"
                        :message="[
                            'warning',
                            'Check your email for a verification link',
                        ]"
                    />

                    <span
                        v-if="form.processing"
                        class="loading loading-spinner mr-2"
                    ></span>

                    <BaseButton
                        :title="(!form.isDirty && 'No changes') || ''"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="
                            form.processing || !form.isDirty || form.hasErrors
                        "
                    >
                        Save
                    </BaseButton>
                </div>
            </label>
        </form>
    </div>
</template>
