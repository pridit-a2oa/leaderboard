<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { UserRoleIcon, UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faCheck, faMinus, faXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, usePage } from '@inertiajs/vue3';

const extras = ref([
    {
        type: 'Supporter <span class="tooltip-benefit" data-tip="Applies once, to the linked character with the most score. If two linked characters have the same score then most recently active is prioritized.">badge</span>',
    },
    {
        type: '<span class="tooltip-benefit" data-tip="By default, characters must gain score within the past 6 weeks to be eligible for ranking.">Inactivity</span> exemption',
    },
    { type: 'Multiple character linking' },
    {
        type: `<span class="tooltip-benefit" data-tip="${usePage().props.statistics.join(', ').toString()}">Statistics</span> tracking (while linked)`,
    },
]);

const icon = {
    'member': [faXmark, 'text-error'],
    'supporter': [faCheck, 'text-success'],
    'admin': [faMinus, 'text-neutral-500'],
};
</script>

<template>
    <Head title="Settings &#x2022; Extras" />

    <DefaultLayout>
        <UserSettings title="Extras">
            <a
                v-if="$page.props.roles.includes('member')"
                href="https://ko-fi.com/pridit"
                target="_blank"
            >
                <Alert
                    type="info"
                    message="Support on Ko-fi to access additional features"
                />
            </a>

            <div class="indicator w-auto">
                <UserRoleIcon />

                <table class="table table-fixed rounded-md bg-base-200">
                    <tbody>
                        <tr
                            v-for="extra in extras"
                            class="border-base-100 [&:not(:last-child)]:!border-b-4"
                        >
                            <td class="w-0">
                                <FontAwesomeIcon
                                    class="!align-middle"
                                    :class="icon[$page.props.roles[0]][1]"
                                    :icon="icon[$page.props.roles[0]][0]"
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
