<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faTrophy,
    faAngleUp,
    faAngleDown,
    faLock,
    faUser,
} from '@fortawesome/free-solid-svg-icons';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
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
        <Head title="Leaderboard">
            <meta
                name="description"
                content="Track and compare your score with the rest of the community"
            />

            <!-- Open Graph -->
            <meta property="og:title" content="Leaderboard" />
            <meta
                property="og:description"
                content="Track and compare your score with the rest of the community"
            />
            <meta
                property="og:image"
                content="https://arma.pridit.co.uk/images/logo.png"
            />
        </Head>

        <main class="container mx-auto text-neutral-400">
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
                            <th class="w-0 text-center">Score</th>
                            <th class="hidden w-0 text-right md:table-cell">
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
                                        :icon="faTrophy"
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
                                        class="ml-1 !align-middle text-neutral-400"
                                        :icon="
                                            key === open
                                                ? faAngleUp
                                                : faAngleDown
                                        "
                                        size="sm"
                                        fixed-width
                                    />
                                </td>

                                <td class="hidden text-right md:table-cell">
                                    <template
                                        v-if="
                                            $page.props.auth.user !== null &&
                                            $page.props.auth.user.connections.some(
                                                (e) =>
                                                    e.pivot.identifier ===
                                                    character.uid,
                                            )
                                        "
                                    >
                                        <span
                                            v-if="
                                                $page.props.auth.user !==
                                                    null &&
                                                $page.props.auth.user.characters.some(
                                                    (e) =>
                                                        e.id === character.id,
                                                )
                                            "
                                            class="badge badge-primary badge-outline badge-sm select-none font-light uppercase"
                                            >You</span
                                        >

                                        <template v-else>
                                            <Link
                                                v-if="
                                                    $page.props.permissions.includes(
                                                        'member',
                                                    ) &&
                                                    $page.props.auth.user
                                                        .characters.length > 0
                                                "
                                                class="badge badge-error badge-outline badge-sm select-none font-light uppercase"
                                                href="/settings/features"
                                            >
                                                <font-awesome-icon
                                                    class="mr-1 align-middle"
                                                    :icon="faLock"
                                                    size="2xs"
                                                    fixed-width
                                                />

                                                Link
                                            </Link>

                                            <Link
                                                v-else
                                                :href="route('character.link')"
                                                method="post"
                                                as="button"
                                                :data="{
                                                    character_id: character.id,
                                                }"
                                                class="badge badge-success badge-outline badge-sm select-none font-light uppercase"
                                                preserveScroll
                                            >
                                                <font-awesome-icon
                                                    class="mr-1 align-middle"
                                                    :icon="faUser"
                                                    size="2xs"
                                                    fixed-width
                                                />

                                                Link
                                            </Link>
                                        </template>
                                    </template>

                                    <a
                                        v-else
                                        :href="`https://steamcommunity.com/profiles/${character.uid}`"
                                        target="_blank"
                                    >
                                        <font-awesome-icon
                                            class="align-middle"
                                            :icon="faSteam"
                                            fixed-width
                                        />
                                    </a>
                                </td>

                                <td class="text-center font-bold">
                                    {{ character.score }}
                                </td>

                                <td
                                    class="hidden whitespace-nowrap text-right text-neutral-500 md:table-cell"
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
                                        {{ statistic.pivot.value }}
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
