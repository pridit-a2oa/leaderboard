<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Alert } from '@/Components/ui';
import { UserSettings } from '@/Components/features/user';
import { DangerButton } from '@/Components/buttons';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({});

const deleteUserRequest = () => {
    form.post(route('delete'));
};
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <UserSettings title="Delete Account">
            <Alert
                v-if="$page.props.flash.message.length > 0"
                :type="$page.props.flash.message[0]"
                :message="$page.props.flash.message[1]"
            />

            <div class="flex flex-col gap-6 rounded-md bg-base-200 p-4">
                <p>
                    Please note that this action is
                    <span class="font-bold underline">irreversible</span>
                    and your account
                    <span class="font-bold underline">cannot</span> be restored.
                </p>

                <p>
                    By performing an account deletion the following will be
                    impacted:
                </p>

                <ul
                    class="ml-4 flex list-outside list-disc flex-wrap font-semibold"
                >
                    <li>Your email address can be re-used</li>
                    <li>Any linked characters will be unlinked</li>
                    <li>Any connections will be severed (e.g. Steam)</li>
                    <li>
                        Ko-fi contribution will be unassociated (if supporter)
                    </li>
                </ul>
            </div>

            <div
                class="mt-4 flex flex-row items-center gap-4 rounded-md bg-base-200 p-4"
            >
                <p>Are you sure you want to delete your account?</p>

                <DangerButton
                    class="no-animation btn-sm"
                    :class="{
                        'opacity-25':
                            form.processing ||
                            $page.props.flash.message.length > 0,
                    }"
                    :disabled="
                        form.processing || $page.props.flash.message.length > 0
                    "
                    @click="deleteUserRequest"
                >
                    Delete Account
                </DangerButton>
            </div>
        </UserSettings>
    </DefaultLayout>
</template>
