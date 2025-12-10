<script setup>
import {
    AnonymiseBadge,
    ResetBadge,
    UnlinkBadge,
} from '@/Components/features/character';
import { UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { isHighestScore } from '@/utils';
import { faCircle, faHeart, faPerson } from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings &dash; Characters" />

    <UserSettings title="Characters">
        <Alert
            v-if="$page.props.auth.user.characters.length === 0"
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
                    <td class="w-0 pl-3">
                        <FontAwesomeLayers>
                            <FontAwesomeIcon :icon="faPerson" size="lg" />

                            <template
                                v-if="
                                    $page.props.auth.role.name ===
                                        'supporter' &&
                                    isHighestScore(
                                        $page.props.auth.user.characters,
                                        character,
                                    )
                                "
                            >
                                <FontAwesomeIcon
                                    class="z-10 text-supporter"
                                    :icon="faHeart"
                                    size="lg"
                                    transform="shrink-8 right-5 down-8"
                                />

                                <FontAwesomeIcon
                                    class="text-base-200"
                                    :icon="faCircle"
                                    size="lg"
                                    transform="down-8 right-5 shrink-3"
                                />
                            </template>
                        </FontAwesomeLayers>
                    </td>

                    <td
                        class="truncate pr-2 text-neutral-500 hover:break-all hover:text-clip hover:whitespace-normal"
                    >
                        <span class="text-neutral-300">{{
                            character.name
                        }}</span>
                    </td>

                    <td class="text-right">
                        <div
                            class="tooltip tooltip-bottom tooltip-secondary before:!w-[12rem]"
                            data-tip="Toggle whether this character is anonymized publicly"
                        >
                            <AnonymiseBadge
                                :id="character.id"
                                :hidden="character.is_hidden"
                            />
                        </div>

                        <div
                            class="tooltip tooltip-bottom ml-3 tooltip-warning before:!w-[12rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Unlink this character from your account&#10;(can be relinked at any time)"
                        >
                            <UnlinkBadge :id="character.id" />
                        </div>

                        <div
                            v-if="
                                ['admin', 'supporter'].includes(
                                    $page.props.auth.role.name,
                                ) && character.statistics_count > 0
                            "
                            class="tooltip tooltip-bottom ml-3 tooltip-error before:!w-[11rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Reset statistics for this character&#10;(cannot be reversed)"
                        >
                            <ResetBadge :id="character.id" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </UserSettings>
</template>
