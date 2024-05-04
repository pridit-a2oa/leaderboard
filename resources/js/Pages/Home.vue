<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
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
    <DefaultLayout>
        <main class="container mx-auto text-neutral-400">
            <Head title="Leaderboard">
                <link rel="icon" href="/images/logo.png" />
            </Head>

            <Navigation />

            <div
                v-if="characters.data.length > 0"
                class="mb-8 mt-4 overflow-x-auto font-bold"
            >
                <table class="table border-separate border-spacing-y-0.5">
                    <thead>
                        <tr class="bg-base-100">
                            <th class="w-0">Rank</th>
                            <th>Name</th>
                            <th class="hidden w-0 md:table-cell"></th>
                            <th class="w-0">Score</th>
                            <th class="hidden w-0 md:table-cell">
                                Last Updated
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-base-300">
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
                                        class="ml-0.5 !align-middle"
                                        :icon="[
                                            'fas',
                                            'arrow-up-right-from-square',
                                        ]"
                                        size="2xs"
                                        fixed-width
                                    />
                                </a>
                            </td>

                            <td class="hidden md:table-cell">
                                <!-- <Link
                                    class="badge badge-accent badge-outline badge-sm select-none font-light"
                                    href="#"
                                    >LINK</Link
                                > -->

                                <!-- <span
                                    class="badge badge-primary badge-outline badge-sm select-none font-light opacity-80"
                                    href="#"
                                    >YOU</span
                                > -->
                            </td>

                            <td class="text-center font-bold">
                                {{ character.score }}
                            </td>

                            <td
                                class="hidden whitespace-nowrap text-neutral-500 md:table-cell"
                            >
                                {{ character.last_seen }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="mt-8 flex w-full flex-col">
                <div class="divider">No records found</div>
            </div>

            <Pagination
                :links="characters.links"
                :currentPage="characters.current_page"
            />
        </main>
    </DefaultLayout>
</template>
