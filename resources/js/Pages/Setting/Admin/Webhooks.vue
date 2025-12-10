<script setup>
import { BaseModal } from '@/Components/base';
import { UserSettings } from '@/Components/features/user';
import { FormInput, FormTextarea } from '@/Components/forms/elements';
import { Alert } from '@/Components/ui';
import {
    faCircleNodes,
    faMagnifyingGlass,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    webhooks: {
        type: Object,
    },
});

const form = useForm({
    headers: '',
    payload: '',
    exception: '',
});
</script>

<template>
    <Head title="Settings &dash; Webhooks" />

    <Teleport to="body">
        <BaseModal id="modal_webhook">
            <h2 class="text-lg font-bold">Webhook</h2>

            <form @submit.prevent="submit">
                <div class="form-control">
                    <label class="divider divider-end">Headers</label>

                    <FormInput
                        id="headers"
                        type="headers"
                        class="!border-transparent"
                        readonly="true"
                        :value="form.headers"
                    />

                    <label class="divider divider-end">Payload</label>

                    <FormTextarea
                        id="payload"
                        type="payload"
                        class="!cursor-text whitespace-nowrap"
                        readonly="true"
                        :value="JSON.stringify(form.payload, null, 2)"
                        rows="10"
                        disabled
                    />

                    <label class="divider divider-end">Exception</label>

                    <FormInput
                        id="exception"
                        type="exception"
                        class="!border-transparent"
                        readonly="true"
                        :value="form.exception"
                    />
                </div>
            </form>
        </BaseModal>
    </Teleport>

    <UserSettings title="Webhooks">
        <Alert
            v-if="webhooks.data.length === 0"
            message="No webhook calls found"
        />

        <div v-else>
            <table class="table table-fixed rounded-md bg-base-200">
                <tbody>
                    <tr
                        v-for="webhook in webhooks.data"
                        :key="webhook.id"
                        class="border-base-100 [&:not(:first-child)]:!border-t-4 [&:not(:last-child)]:!border-b-4"
                    >
                        <td class="w-0">
                            <FontAwesomeIcon
                                class="!align-middle"
                                :icon="faCircleNodes"
                                size="lg"
                            />
                        </td>

                        <td>
                            {{ webhook.url }}
                        </td>

                        <td
                            class="w-40 text-right text-xs text-neutral-400"
                            :title="webhook.created_at"
                        >
                            {{ webhook.formatted_created_at }}
                        </td>

                        <td class="w-12 text-right">
                            <label
                                for="webhook-modal"
                                role="button"
                                title="Inspect"
                                tabindex="0"
                                onclick="modal_webhook.showModal()"
                                @click="
                                    Object.assign(
                                        form,
                                        Object.fromEntries(
                                            Object.entries(webhook).filter(
                                                ([key]) =>
                                                    [
                                                        'headers',
                                                        'payload',
                                                        'exception',
                                                    ].includes(key),
                                            ),
                                        ),
                                    )
                                "
                            >
                                <FontAwesomeIcon
                                    class="cursor-pointer !align-middle"
                                    title="Inspect"
                                    :icon="faMagnifyingGlass"
                                />
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </UserSettings>
</template>
