<script setup>
import { UserRoleIcon, UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faCheck, faMinus, faXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, usePage } from '@inertiajs/vue3';

const extras = [
    'Supporter <span class="underlined-rich tooltip tooltip-bottom tooltip-secondary before:!w-[12rem]" data-tip="Applies to one linked character with the highest score (and most recently active)">badge</span>',
    'Multiple character linking',
    `<span class="underlined-rich tooltip tooltip-bottom tooltip-secondary before:!w-[14rem]" data-tip="${usePage().props.statistics}">Statistics</span> tracking (per character)`,
];

const icon = {
    'member': [faXmark, 'text-error'],
    'supporter': [faCheck, 'text-success'],
    'admin': [faMinus, 'text-neutral-500'],
};
</script>

<template>
    <Head title="Settings &dash; Extras" />

    <UserSettings title="Extras">
        <a
            v-if="$page.props.auth.role.name === 'member'"
            href="https://ko-fi.com/pridit"
            target="_blank"
        >
            <Alert
                type="info"
                message="Support on Ko-fi to access additional features"
            />
        </a>

        <Alert
            v-if="$page.props.auth.role.name === 'admin'"
            message="Some features are inherited due to role override"
        />

        <div class="indicator w-auto">
            <UserRoleIcon v-if="$page.props.auth.role.name !== 'admin'" />

            <table class="bg-base-200 table table-fixed rounded-md">
                <tbody>
                    <tr
                        v-for="extra in extras"
                        class="border-base-100 [&:not(:first-child)]:!border-t-4"
                    >
                        <td class="w-0 pl-3">
                            <FontAwesomeIcon
                                class="!align-middle"
                                :class="icon[$page.props.auth.role.name][1]"
                                :icon="icon[$page.props.auth.role.name][0]"
                                size="lg"
                                transform="shrink-2 up-1"
                            />
                        </td>

                        <td class="p-0 pl-3" v-html="extra"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </UserSettings>
</template>
