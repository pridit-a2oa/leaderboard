<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    characters: {
        type: Object,
    },
    statistics: {
        type: Object,
    },
});

const open = ref(null);

function toggle(id) {
    open.value = open.value === id ? null : id;
}
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
                <table class="table border-collapse">
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
                        <template
                            v-for="(character, key) in characters.data"
                            :key="character.id"
                        >
                            <tr class="!border-t-2 border-base-100">
                                <td
                                    v-if="
                                        characters.current_page === 1 &&
                                        key in [0, 1, 2]
                                    "
                                    class="text-center"
                                >
                                    <font-awesome-icon
                                        class="align-middle"
                                        :class="{
                                            'text-gold': key === 0,
                                            'text-silver': key === 1,
                                            'text-bronze': key === 2,
                                        }"
                                        :icon="['fas', 'trophy']"
                                        fixed-width
                                    />
                                </td>

                                <td
                                    v-else
                                    class="flex justify-center font-bold"
                                >
                                    {{
                                        key +
                                        (characters.current_page - 1) *
                                            characters.per_page +
                                        1
                                    }}
                                </td>

                                <td
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
                                        'cursor-pointer':
                                            character.statistics.length > 0,
                                    }"
                                    @click="toggle(key)"
                                >
                                    {{ character.name
                                    }}<font-awesome-icon
                                        v-if="character.statistics.length > 0"
                                        class="ml-0.5 !align-middle text-neutral-500"
                                        :icon="[
                                            'fas',
                                            key === open
                                                ? 'caret-up'
                                                : 'caret-down',
                                        ]"
                                        size="sm"
                                        fixed-width
                                    />
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

                                    <a
                                        :href="`https://steamcommunity.com/profiles/${character.uid}`"
                                        target="_blank"
                                    >
                                        <font-awesome-icon
                                            class="align-middle"
                                            :icon="['brands', 'steam']"
                                            fixed-width
                                        />
                                    </a>
                                </td>

                                <td class="text-center font-bold">
                                    {{ character.score }}
                                </td>

                                <td
                                    class="hidden whitespace-nowrap text-neutral-500 md:table-cell"
                                >
                                    {{ character.updated_at }}
                                </td>
                            </tr>

                            <template
                                v-if="
                                    key === open &&
                                    character.statistics.length > 0
                                "
                            >
                                <tr
                                    v-for="statistic in character.statistics.sort(
                                        (a, b) => (a.name > b.name ? 1 : -1),
                                    )"
                                    class="bg-base-200 text-xs text-neutral-500"
                                >
                                    <td></td>
                                    <td>{{ statistic.name }}</td>
                                    <td class="hidden md:table-cell"></td>
                                    <td class="text-center">
                                        {{ statistic.value }}
                                    </td>
                                    <td class="hidden md:table-cell"></td>
                                </tr>
                            </template>
                        </template>
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
