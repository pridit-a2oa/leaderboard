<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faCircleNodes } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/vue3';

defineProps({
    webhooks: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Settings &#x2022; Webhooks" />

    <DefaultLayout>
        <UserSettings title="Webhooks">
            <Alert
                v-if="webhooks.data.length === 0"
                type="warning"
                message="No webhooks found"
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
                                    :icon="faCircleNodes"
                                    size="lg"
                                />
                            </td>

                            <td>
                                {{ webhook.url }}
                            </td>

                            <td
                                class="truncate hover:text-clip hover:whitespace-normal hover:break-all"
                            >
                                {{ webhook.payload }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </UserSettings>
    </DefaultLayout>
</template>
