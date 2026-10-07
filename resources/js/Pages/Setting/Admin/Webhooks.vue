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
import { ref } from 'vue';

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

const modal = ref(null);
const payload = ref(null);

const openModal = async (webhook) => {
    Object.assign(
        form,
        Object.fromEntries(
            Object.entries(webhook).filter(([key]) =>
                ['headers', 'payload', 'exception'].includes(key),
            ),
        ),
    );
    payload.value.$el.nextElementSibling.scrollTop = 0;
    modal.value.$el.showModal();
};
</script>

<template>
    <Head title="Settings &dash; Webhooks" />

    <Teleport to="body">
        <BaseModal ref="modal" id="modal_webhook">
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
                        ref="payload"
                        id="payload"
                        type="payload"
                        class="!cursor-text"
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

    <UserSettings heading="Webhooks">
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
                            class="relative text-right text-xs text-neutral-400"
                            :title="webhook.created_at"
                        >
                            <span class="mr-10">{{
                                webhook.formatted_created_at
                            }}</span>

                            <button
                                class="btn absolute top-1/2 right-4 size-7 -translate-y-1/2 border-none btn-soft !p-0 btn-sm hover:!bg-highlight"
                                title="Inspect"
                                aria-label="Inspect"
                                @click="openModal(webhook)"
                            >
                                <FontAwesomeIcon :icon="faMagnifyingGlass" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </UserSettings>
</template>
