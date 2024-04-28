<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    characters: {
        type: Object,
    },
});
</script>

<template>
    <main class="container mx-auto text-neutral-400">
        <Head title="Leaderboard" />

        <Navigation />

        <div class="mb-2 mt-6 flex justify-center">
            <a
                href="https://dsc.gg/pridit"
                class="btn no-animation mr-2"
                target="_blank"
            >
                Discord
                <font-awesome-icon
                    :icon="['fas', 'arrow-up-right-from-square']"
                    size="xs"
                />
            </a>

            <a
                href="https://feedback.pridit.co.uk"
                class="btn no-animation mr-2"
                target="_blank"
            >
                Feedback
                <font-awesome-icon
                    :icon="['fas', 'arrow-up-right-from-square']"
                    size="xs"
                />
            </a>

            <a
                href="https://ko-fi.com/pridit"
                class="btn no-animation"
                target="_blank"
            >
                Ko-fi
                <font-awesome-icon
                    :icon="['fas', 'arrow-up-right-from-square']"
                    size="xs"
                />
            </a>
        </div>

        <div
            v-if="characters.data.length > 0"
            class="overflow-x-auto pb-10 font-bold"
        >
            <table class="table border-separate">
                <thead>
                    <tr class="bg-base-100">
                        <th class="w-0">Rank</th>
                        <th>Name</th>
                        <th class="w-0">Score</th>
                        <th class="hidden w-0 sm:table-cell">Last Seen</th>
                    </tr>
                </thead>

                <tbody class="rounded-full bg-base-300">
                    <tr
                        v-for="(character, key) in characters.data"
                        :key="character.id"
                    >
                        <td
                            v-if="
                                characters.current_page === 1 &&
                                key in [0, 1, 2]
                            "
                            class="text-center"
                        >
                            <font-awesome-icon
                                :class="{
                                    'text-gold': key === 0,
                                    'text-silver': key === 1,
                                    'text-bronze': key === 2,
                                }"
                                :icon="['fas', 'medal']"
                                size="lg"
                                fixed-width
                            />
                        </td>

                        <td v-else class="flex justify-center font-bold">
                            {{
                                key +
                                (characters.current_page - 1) *
                                    characters.per_page +
                                1
                            }}
                        </td>

                        <td>
                            <a
                                :href="`https://steamcommunity.com/profiles/${character.uid}`"
                                :class="{
                                    '!text-gold':
                                        characters.current_page === 1 &&
                                        key === 0,
                                    '!text-silver':
                                        characters.current_page === 1 &&
                                        key === 1,
                                    '!text-bronze':
                                        characters.current_page === 1 &&
                                        key === 2,
                                }"
                                target="_blank"
                            >
                                {{ character.name }}

                                <font-awesome-icon
                                    class="ml-0.5 !align-middle text-neutral-500"
                                    :icon="[
                                        'fas',
                                        'arrow-up-right-from-square',
                                    ]"
                                    size="2xs"
                                    fixed-width
                                />
                            </a>
                        </td>

                        <td class="text-center font-bold">
                            {{ character.score }}
                        </td>

                        <td
                            class="hidden whitespace-nowrap text-neutral-500 sm:table-cell"
                        >
                            {{ character.last_seen }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="flex w-full flex-col">
            <div class="divider">No records found</div>
        </div>

        <Pagination :links="characters.links" />
    </main>
</template>
