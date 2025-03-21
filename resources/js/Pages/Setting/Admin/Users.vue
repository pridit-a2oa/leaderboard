<script setup>
import { UserSettings } from '@/Components/features/user';
import { faCircleUser } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/vue3';

defineProps({
    users: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Settings &#x2022; Users" />

    <UserSettings title="Users">
        <table class="table mt-2 table-fixed rounded-md bg-base-200">
            <tbody>
                <tr
                    v-for="user in users.data"
                    :key="user.id"
                    class="border-base-100 [&:not(:first-child)]:!border-t-4 [&:not(:last-child)]:!border-b-4"
                >
                    <td class="w-10">
                        <FontAwesomeIcon
                            class="!align-middle"
                            :icon="faCircleUser"
                            size="lg"
                            fixed-width
                        />
                    </td>

                    <td>
                        {{ user.email ?? 'N/A' }}
                    </td>

                    <td>
                        {{ user.role }}
                    </td>
                </tr>
            </tbody>
        </table>
    </UserSettings>
</template>
