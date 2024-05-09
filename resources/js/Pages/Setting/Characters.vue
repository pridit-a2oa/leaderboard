<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { watchEffect } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';

watchEffect(() => {
    window.Laravel.jsPermissions = usePage().props.permissions;
});
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
                <tr v-for="character in $page.props.auth.user.characters">
                    <td class="w-0">
                        <font-awesome-icon
                            class="!align-middle"
                            :icon="['fas', 'user']"
                            size="sm"
                            fixed-width
                        />
                    </td>

                    <td class="w-28 break-all pr-2 font-bold">
                        {{ character.name }}
                    </td>

                    <td class="text-right">
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
                                class="mr-1 align-middle"
                                :icon="[
                                    'fas',
                                    character.is_visible ? 'eye' : 'eye-slash',
                                ]"
                                size="2xs"
                                fixed-width
                            />

                            <span v-if="character.is_visible">Public</span>
                            <span v-else>Hidden</span>
                        </Link>

                        <Link
                            :href="route('character.unlink')"
                            method="post"
                            as="button"
                            :data="{
                                character_id: character.id,
                            }"
                            class="badge badge-accent badge-outline badge-sm ml-2 select-none font-light uppercase"
                            preserveScroll
                        >
                            <font-awesome-icon
                                class="mr-1 align-middle"
                                :icon="['fas', 'user-slash']"
                                size="2xs"
                                fixed-width
                            />

                            Unlink
                        </Link>

                        <div
                            class="tooltip tooltip-bottom tooltip-error before:w-[14rem] before:whitespace-pre-line before:content-[attr(data-tip)]"
                            data-tip="Score &amp; any additional statistics will be reset for this character&#10;&#10;This action cannot be reversed"
                        >
                            <Link
                                v-if="
                                    is('admin | supporter') &&
                                    parseInt(
                                        character.score.replaceAll(',', ''),
                                    ) > 0
                                "
                                :href="route('character.reset')"
                                method="post"
                                as="button"
                                :data="{
                                    character_id: character.id,
                                }"
                                class="badge badge-error badge-outline badge-sm ml-2 select-none font-light uppercase"
                                preserveScroll
                            >
                                <font-awesome-icon
                                    class="mr-1 align-middle"
                                    :icon="['fas', 'rotate']"
                                    size="2xs"
                                    fixed-width
                                />

                                Reset
                            </Link>
                        </div>
                    </td>
                </tr>
            </table>
        </Setting>
    </DefaultLayout>
</template>
