<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';
import {
    VisibilityButton,
    UnlinkButton,
    ResetButton,
} from '@/Components/Submit';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Characters">
            <Alert
                v-if="$page.props.auth.user.characters.length === 0"
                type="warning"
                message="You have no linked characters"
            />

            <table
                class="table table-fixed border-separate border-spacing-x-0 border-spacing-y-1 rounded-md bg-base-200"
            >
                <tr
                    v-for="character in $page.props.auth.user.characters.sort(
                        (a, b) => (a.name > b.name ? 1 : -1),
                    )"
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
                            class="tooltip tooltip-bottom tooltip-secondary before:w-[13rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Toggle the visibility of this character in the leaderboard"
                        >
                            <VisibilityButton
                                :id="character.id"
                                :visible="character.is_visible"
                            />
                        </div>

                        <div
                            class="tooltip tooltip-bottom tooltip-warning ml-3 before:w-[17rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Unlink this character from your account (can be relinked at any time)"
                        >
                            <UnlinkButton :id="character.id" />
                        </div>

                        <div
                            v-if="
                                $page.props.roles.some((role) =>
                                    ['admin', 'supporter'].includes(role),
                                ) && character.score > 0
                            "
                            class="tooltip tooltip-bottom tooltip-error ml-3 before:w-[13rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Reset score and any additional statistics for this character&#10;(cannot be reversed)"
                        >
                            <ResetButton :id="character.id" />
                        </div>
                    </td>
                </tr>
            </table>
        </Setting>
    </DefaultLayout>
</template>
