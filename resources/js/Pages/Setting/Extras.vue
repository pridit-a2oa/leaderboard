<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserSettings, UserSupporterIcon } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faCheck, faXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, usePage } from '@inertiajs/vue3';

const extras = ref([
    {
        type: 'Supporter <span class="tooltip-benefit" data-tip="Applies to the linked character with the highest score. If more linked characters have the same score then most recently active is prioritized.">badge</span>',
    },
    {
        type: '<span class="tooltip-benefit" data-tip="By default, characters must gain score within the last 6 weeks to be eligible for ranking.">Inactivity</span> exemption',
    },
    { type: 'Multiple character linking' },
    {
        type: `<span class="tooltip-benefit" data-tip="${usePage().props.statistics.join(', ').toString()}">Statistics</span> tracking (while linked)`,
    },
]);

const benefits = usePage().props.roles.some((role) =>
    ['admin', 'supporter'].includes(role),
);
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <UserSettings title="Extras">
            <a v-if="!benefits" href="https://ko-fi.com/pridit" target="_blank">
                <Alert
                    type="info"
                    message="Support on Ko-fi to unlock additional features"
                />
            </a>

            <div class="indicator w-auto">
                <UserSupporterIcon />

                <table class="table table-fixed rounded-md bg-base-200">
                    <tbody>
                        <tr
                            v-for="extra in extras"
                            class="border-base-100 [&:not(:last-child)]:!border-b-4"
                        >
                            <td class="w-0">
                                <FontAwesomeIcon
                                    class="!align-middle"
                                    :class="[
                                        benefits
                                            ? 'text-success'
                                            : 'text-error',
                                    ]"
                                    :icon="benefits ? faCheck : faXmark"
                                    size="lg"
                                    transform="shrink-1"
                                />
                            </td>
                            <td class="p-0 pl-3" v-html="extra.type"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </UserSettings>
    </DefaultLayout>
</template>
