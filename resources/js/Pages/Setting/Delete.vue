<script setup>
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

    <UserSettings title="Delete Account">
        <Alert
            v-if="$page.props.auth.user.is_deletion_throttled"
            type="success"
            message="Please check your email for a confirmation link"
        />

        <div class="bg-base-200 flex flex-col gap-6 rounded-md p-4 text-sm">
            <p>
                Be aware that by performing an account deletion the following
                will be impacted:
            </p>

            <ul class="ml-3.5 flex list-outside list-disc flex-wrap">
                <li v-if="$page.props.auth.user.email">
                    Email address can be re-used
                </li>
                <li>Connections will be severed</li>
                <li>Any linked characters will be unlinked</li>
                <li v-if="$page.props.auth.role.name === 'supporter'">
                    Ko-fi contribution will be unassociated
                    <span
                        class="underlined-rich tooltip-benefit"
                        data-tip="If you change your mind
                    and decide to re-register we'll be able to reassociate
                    your benefits with a new account"
                    >
                        (?)</span
                    >
                </li>
            </ul>

            <p>
                Please confirm below that you wish to continue with this
                destructive action.
            </p>
        </div>

        <div class="bg-base-200 mt-4 flex flex-row gap-4 rounded-md p-4">
            <form @change="deleteUserRequest">
                <FormCheckbox
                    :checked="$page.props.auth.user.is_deletion_throttled"
                    :disabled="
                        form.processing ||
                        $page.props.auth.user.is_deletion_throttled
                    "
                >
                    <span class="block">
                        I understand this action is
                        <span class="text-error">irreversible</span> and that my
                        account cannot be restored.
                        <span class="font-bold">Continue anyway</span>.
                    </span>
                </FormCheckbox>
            </form>
        </div>
    </UserSettings>
</template>
