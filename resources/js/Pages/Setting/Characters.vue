<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faUser,
    faEye,
    faEyeSlash,
    faUserSlash,
    faRotate,
} from '@fortawesome/free-solid-svg-icons';
import { Head, Link } from '@inertiajs/vue3';
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
                        <font-awesome-icon
                            class="!align-middle"
                            :icon="faUser"
                            size="sm"
                            fixed-width
                        />
                    </td>

                    <td class="break-all pr-2 font-bold">
                        {{ character.name }}
                    </td>

                    <td class="text-right">
                        <div
                            class="tooltip tooltip-bottom tooltip-secondary before:w-[13rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Toggle the visibility of this character in the leaderboard"
                        >
                            <Link
                                :href="route('character.visibility')"
                                method="post"
                                as="button"
                                :data="{
                                    character_id: character.id,
                                }"
                                class="badge badge-outline badge-sm select-none font-light uppercase"
                                :class="{
                                    'opacity-60': !character.is_visible,
                                }"
                                preserveScroll
                            >
                                <font-awesome-icon
                                    :icon="
                                        character.is_visible
                                            ? faEye
                                            : faEyeSlash
                                    "
                                    size="xs"
                                    fixed-width
                                />
                            </Link>
                        </div>

                        <div
                            class="tooltip tooltip-bottom tooltip-warning ml-3 before:w-[17rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Unlink this character from your account (can be relinked at any time)"
                        >
                            <Link
                                :href="route('character.unlink')"
                                method="post"
                                as="button"
                                :data="{
                                    character_id: character.id,
                                }"
                                class="badge badge-warning badge-outline badge-sm select-none uppercase"
                                preserveScroll
                            >
                                <font-awesome-icon
                                    :icon="faUserSlash"
                                    size="xs"
                                    fixed-width
                                />
                            </Link>
                        </div>

                        <div
                            v-if="
                                $page.props.permissions.some((role) =>
                                    ['admin', 'supporter'].includes(role),
                                ) &&
                                parseInt(character.score.replaceAll(',', '')) >
                                    0
                            "
                            class="tooltip tooltip-bottom tooltip-error ml-3 before:w-[13rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Reset score and any additional statistics for this character&#10;(cannot be reversed)"
                        >
                            <Link
                                :href="route('character.reset')"
                                method="post"
                                as="button"
                                :data="{
                                    character_id: character.id,
                                }"
                                class="badge badge-error badge-outline badge-sm select-none uppercase"
                                preserveScroll
                            >
                                <font-awesome-icon
                                    :icon="faRotate"
                                    size="xs"
                                    fixed-width
                                />
                            </Link>
                        </div>
                    </td>
                </tr>
            </table>
        </Setting>
    </DefaultLayout>
</template>
