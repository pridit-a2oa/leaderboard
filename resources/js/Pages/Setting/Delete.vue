<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserSettings } from '@/Components/features/user';
import { FormCheckbox } from '@/Components/forms/elements';
import { Alert } from '@/Components/ui';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({});

const deleteUserRequest = () => {
    form.post(route('delete'));
};
</script>

<template>
    <Head title="Settings &#x2022; Delete Account" />

    <DefaultLayout>
        <UserSettings title="Delete Account">
            <Alert
                v-if="form.processing || $page.props.auth.user.delete_token"
                type="success"
                message="Please check your email for a confirmation link"
            />

            <div class="flex flex-col gap-6 rounded-md bg-base-200 p-4 text-sm">
                <p>
                    Be aware that by performing an account deletion the
                    following will be impacted:
                </p>

                <ul class="ml-3.5 flex list-outside list-disc flex-wrap">
                    <li>Email address can be re-used</li>
                    <li v-if="$page.props.auth.user.connections.length > 0">
                        Connection(s) will be severed
                    </li>
                    <li v-if="$page.props.auth.user.characters.length > 0">
                        Linked character(s) will be unlinked
                    </li>
                    <li v-if="$page.props.roles.includes('supporter')">
                        Ko-fi contribution will be unassociated<br />(<span
                            class="tooltip-benefit"
                            data-tip="Please either reach out directly on Ko-fi or email in to privacy@pridit.co.uk
                            with receipt of donation"
                        >
                            I want to delete</span
                        >)
                    </li>
                </ul>

                <p>
                    Please confirm below that you wish to continue with this
                    destructive action.
                </p>
            </div>

            <div class="mt-4 flex flex-row gap-4 rounded-md bg-base-200 p-4">
                <form @change="deleteUserRequest">
                    <FormCheckbox
                        :checked="$page.props.auth.user.delete_token !== null"
                        :disabled="
                            form.processing ||
                            $page.props.auth.user.delete_token
                        "
                    >
                        <span class="ml-1 block">
                            I understand this action is
                            <span class="text-error">irreversible</span> and
                            that my account
                            <span class="text-warning">cannot</span> be
                            restored.
                            <span class="font-bold">Continue anyway</span>.
                        </span>
                    </FormCheckbox>
                </form>
            </div>
        </UserSettings>
    </DefaultLayout>
</template>
