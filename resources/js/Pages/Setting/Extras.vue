<script setup>
import { UserRoleIcon, UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faCheck, faMinus, faXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, usePage } from '@inertiajs/vue3';

const extras = [
    'Supporter <span class="tooltip-benefit" data-tip="Applies to the linked character with the highest score (and most recently active)">badge</span>',
    '<span class="tooltip-benefit" data-tip="Bypasses the requirement to have gained score sometime within the past 6 weeks to be eligible for ranking">Inactivity</span> exemption',
    'Multiple character linking',
    `<span class="tooltip-benefit" data-tip="${usePage().props.statistics.join(', ').toString()}">Statistics</span> tracking (while linked)`,
];

const icon = {
    'member': [faXmark, 'text-error'],
    'supporter': [faCheck, 'text-success'],
    'admin': [faMinus, 'text-neutral-500'],
};
</script>

<template>
    <Head title="Settings &#x2022; Extras" />

    <UserSettings title="Extras">
        <a
            v-if="$page.props.auth.role === 'member'"
            href="https://ko-fi.com/pridit"
            target="_blank"
        >
            <Alert
                type="info"
                message="Support on Ko-fi to access additional features"
            />
        </a>

        <Alert
            v-if="$page.props.auth.role === 'admin'"
            message="Some features are inherited due to role override"
        />

        <div class="indicator w-auto">
            <UserRoleIcon v-if="$page.props.auth.role !== 'admin'" />

            <table class="table table-fixed rounded-md bg-base-200">
                <tbody>
                    <tr
                        v-for="extra in extras"
                        class="border-base-100 [&:not(:last-child)]:!border-b-4"
                    >
                        <td class="w-0">
                            <FontAwesomeIcon
                                class="!align-middle"
                                :class="icon[$page.props.auth.role][1]"
                                :icon="icon[$page.props.auth.role][0]"
                                size="lg"
                                transform="shrink-1"
                            />
                        </td>

                        <td class="p-0 pl-3" v-html="extra"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </UserSettings>
</template>
