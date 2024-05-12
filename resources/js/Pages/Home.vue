<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';
import TableStatistics from '@/Components/TableStatistics.vue';
import { LinkButton } from '@/Components/Submit';
import { ref } from 'vue';
import {
    faTrophy,
    faAngleUp,
    faAngleDown,
    faLock,
} from '@fortawesome/free-solid-svg-icons';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, Link } from '@inertiajs/vue3';

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

            <div v-if="characters.data.length > 0" class="mb-8 mt-4 font-bold">
                <table class="table border-collapse">
                    <thead>
                        <tr class="bg-base-100">
                            <th class="w-0">Rank</th>
                            <th>Name</th>
                            <th class="hidden w-0 md:table-cell"></th>
                            <th class="w-0 text-right">Score</th>
                            <th class="hidden w-0 md:table-cell"></th>
                        </tr>
                    </thead>

                    <tbody class="bg-base-300">
                        <template
                            v-for="(character, key) in characters.data"
                            :key="character.id"
                        >
                            <tr
                                class="!border-b-4 border-base-100 [&:not(:first-child)]:!border-t-4"
                            >
                                <td
                                    v-if="
                                        characters.current_page === 1 &&
                                        key in [0, 1, 2]
                                    "
                                    class="text-center"
                                >
                                    <FontAwesomeIcon
                                        class="!align-middle"
                                        :class="{
                                            'text-gold': key === 0,
                                            'text-silver': key === 1,
                                            'text-bronze': key === 2,
                                        }"
                                        :icon="faTrophy"
                                        size="lg"
                                        fixed-width
                                    />
                                </td>

                                <td v-else class="text-center font-bold">
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
                                            character.statistics.length > 0 &&
                                            character.user_id !== null,
                                    }"
                                    @click="
                                        character.statistics.length > 0 &&
                                        character.user_id !== null
                                            ? toggle(key)
                                            : null
                                    "
                                >
                                    {{ character.name
                                    }}<FontAwesomeIcon
                                        v-if="
                                            character.statistics.length > 0 &&
                                            character.user_id !== null
                                        "
                                        class="ml-1 !align-middle text-neutral-400"
                                        :icon="
                                            key === open
                                                ? faAngleUp
                                                : faAngleDown
                                        "
                                        size="sm"
                                        fixed-width
                                    />
                                    <span
                                        class="mt-0.5 flex select-none text-xs font-light text-neutral-500"
                                        title="Last active"
                                        >{{ character.updated_at }}</span
                                    >
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
                                                :href="
                                                    route(
                                                        'user.setting.features',
                                                    )
                                                "
                                            >
                                                <FontAwesomeIcon
                                                    class="mr-1"
                                                    :icon="faLock"
                                                    size="2xs"
                                                    fixed-width
                                                />

                                                Link
                                            </Link>

                                            <LinkButton
                                                v-else
                                                :id="character.id"
                                            />
                                        </template>
                                    </template>
                                </td>

                                <td class="text-bold text-right text-[1rem]">
                                    {{ character.score }}
                                </td>

                                <td class="hidden md:table-cell">
                                    <a
                                        :href="`https://steamcommunity.com/profiles/${character.uid}`"
                                        target="_blank"
                                    >
                                        <FontAwesomeIcon
                                            class="!align-middle text-neutral-500"
                                            :icon="faSteam"
                                            size="lg"
                                            fixed-width
                                        />
                                    </a>
                                </td>
                            </tr>

                            <tr
                                v-if="
                                    key === open &&
                                    character.statistics.length > 0 &&
                                    character.user_id !== null
                                "
                            >
                                <td colspan="5" class="p-0">
                                    <TableStatistics
                                        :data="character.statistics"
                                    />
                                </td>
                            </tr>
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
