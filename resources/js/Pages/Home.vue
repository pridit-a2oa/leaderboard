<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';
import TableStatistics from '@/Components/TableStatistics.vue';
import { LinkButton } from '@/Components/Submit';
import {
    faHeart,
    faHeartCrack,
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

        <div class="container mx-auto text-neutral-400">
            <Navigation />

            <div v-if="characters.data.length > 0" class="mt-4 font-bold">
                <table class="rtl table border-collapse">
                    <thead>
                        <tr class="bg-base-100">
                            <th class="hidden w-0 md:table-cell"></th>
                            <th class="w-0 text-right">Score</th>
                            <th class="hidden w-0 md:table-cell"></th>
                            <th class="p-0 px-2">Name</th>
                            <th class="w-0">Rank</th>
                            <th
                                class="hidden w-0 text-center md:table-cell"
                            ></th>
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
                                    class="hidden bg-base-200 p-0 px-2 text-center md:table-cell"
                                >
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

                                <td class="text-bold text-right text-[1rem]">
                                    {{ character.formatted_score }}
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
                                                    $page.props.roles.includes(
                                                        'member',
                                                    ) &&
                                                    $page.props.auth.user
                                                        .characters.length > 0
                                                "
                                                class="ltr badge badge-error badge-outline badge-sm select-none font-light uppercase"
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

                                <td
                                    class="ltr grid p-0 px-2 py-3"
                                    :class="{
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
                                    <span class="truncate">
                                        <FontAwesomeIcon
                                            v-if="
                                                character.statistics.length >
                                                    0 &&
                                                character.user_id !== null
                                            "
                                            class="mr-0.5 !align-middle"
                                            :icon="
                                                key === open
                                                    ? faAngleUp
                                                    : faAngleDown
                                            "
                                            size="sm"
                                            fixed-width
                                        />

                                        <span
                                            class="text-neutral-400"
                                            :class="{
                                                '!text-gold':
                                                    characters.current_page ===
                                                        1 && key === 0,
                                                '!text-silver':
                                                    characters.current_page ===
                                                        1 && key === 1,
                                                '!text-bronze':
                                                    characters.current_page ===
                                                        1 && key === 2,
                                            }"
                                            :title="character.name"
                                            >{{ character.name }}</span
                                        >
                                    </span>

                                    <span
                                        class="mt-0.5 w-max select-none text-xs font-light text-neutral-500"
                                        title="Last Seen"
                                        >{{ character.last_seen_at }}</span
                                    >
                                </td>

                                <td
                                    v-if="
                                        characters.current_page === 1 &&
                                        key in [0, 1, 2]
                                    "
                                    class="bg-base-300 text-center"
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

                                <td
                                    v-else
                                    class="bg-base-300 text-center text-[1rem] font-bold"
                                >
                                    {{
                                        key +
                                        (characters.current_page - 1) *
                                            characters.per_page +
                                        1
                                    }}
                                </td>

                                <td
                                    class="hidden bg-base-200 p-0 px-2.5 text-center md:table-cell"
                                >
                                    <Link
                                        :href="
                                            $page.props.auth.user
                                                ? route('user.setting.features')
                                                : '#'
                                        "
                                    >
                                        <FontAwesomeIcon
                                            v-if="
                                                character.role.name ===
                                                    'supporter' &&
                                                character.is_highest_score
                                            "
                                            class="!align-middle text-supporter opacity-80"
                                            :icon="faHeart"
                                            fixed-width
                                        />

                                        <FontAwesomeIcon
                                            v-else
                                            class="!align-middle text-neutral-700"
                                            :icon="faHeartCrack"
                                            fixed-width
                                        />
                                    </Link>
                                </td>
                            </tr>

                            <tr
                                v-if="
                                    key === open &&
                                    character.statistics.length > 0 &&
                                    character.user_id !== null
                                "
                            >
                                <td
                                    class="p-0"
                                    :colspan="$vssWidth <= 767 ? 2 : 4"
                                >
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
                :from="characters.from"
                :to="characters.to"
                :total="characters.total"
            />
        </div>
    </DefaultLayout>
</template>
