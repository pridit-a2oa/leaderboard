<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import {
    AnonymiseBadge,
    UnlinkBadge,
    ResetBadge,
} from '@/Components/features/character';
import { UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings &#x2022; Characters" />

    <DefaultLayout>
        <UserSettings title="Characters">
            <Alert
                v-if="$page.props.auth.user.characters.length === 0"
                type="warning"
                message="You have no linked characters"
            />

            <table class="table table-fixed rounded-md bg-base-200">
                <tbody>
                    <tr
                        v-for="character in $page.props.auth.user.characters.sort(
                            (a, b) =>
                                a.name.toLowerCase() > b.name.toLowerCase()
                                    ? 1
                                    : -1,
                        )"
                        :key="character.id"
                        class="border-base-100 [&:not(:first-child)]:!border-t-4 [&:not(:last-child)]:!border-b-4"
                    >
                        <td class="w-0">
                            <FontAwesomeIcon
                                class="!align-middle"
                                :icon="faUser"
                                size="sm"
                                fixed-width
                            />
                        </td>

                        <td
                            class="truncate pr-2 font-bold text-neutral-500 hover:text-clip hover:whitespace-normal hover:break-all"
                        >
                            <span class="text-neutral-300">{{
                                character.name
                            }}</span>
                        </td>

                        <td class="text-right">
                            <div
                                class="tooltip tooltip-bottom tooltip-secondary before:w-[12rem]"
                                data-tip="Toggle whether this character is anonymized publicly"
                            >
                                <AnonymiseBadge
                                    :id="character.id"
                                    :hidden="character.is_hidden"
                                />
                            </div>

                            <div
                                class="tooltip tooltip-bottom tooltip-warning ml-3 before:w-[12rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                                data-tip="Unlink this character from your account&#10;(can be relinked at any time)"
                            >
                                <UnlinkBadge :id="character.id" />
                            </div>

                            <div
                                v-if="
                                    $page.props.roles.some((role) =>
                                        ['admin', 'supporter'].includes(role),
                                    ) && character.statistics_count > 0
                                "
                                class="tooltip tooltip-bottom tooltip-error ml-3 before:w-[12rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                                data-tip="Reset statistics for this character&#10;(cannot be reversed)"
                            >
                                <ResetBadge :id="character.id" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </UserSettings>
    </DefaultLayout>
</template>
