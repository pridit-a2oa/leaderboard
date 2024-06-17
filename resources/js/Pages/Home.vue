<script setup>
import { ref } from 'vue';
import { useGrid } from 'vue-screen';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';
import ResetPassword from '@/Components/ResetPassword.vue';
import RewardAlert from '@/Components/RewardAlert.vue';
import TableStatistics from '@/Components/TableStatistics.vue';
import { LinkButton } from '@/Components/Submit';
import {
    faHeart,
    faCircle,
    faTrophy,
    faAngleUp,
    faAngleDown,
    faLock,
    faMinus,
    faChevronUp,
    faChevronDown,
} from '@fortawesome/free-solid-svg-icons';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { Head, Link } from '@inertiajs/vue3';

const grid = useGrid('tailwind');

const props = defineProps({
    characters: {
        type: Object,
    },
    statistics: {
        type: Object,
    },
    ranking: {
        type: Object,
    },
});

const open = ref(null);

function toggle(id) {
    open.value = open.value === id ? null : id;
}

function getRank(key, added) {
    return (
        key +
        ((props.characters.meta.current_page - 1) *
            props.characters.meta.per_page +
            (added ?? 0))
    );
}

function getCachedRank(id) {
    return Object.keys(props.ranking).find((key) => props.ranking[key] === id);
}

function getMovementRank(rank) {
    switch (true) {
        case rank > 0:
            return ['text-success', faChevronUp];
        case rank < 0:
            return ['text-error', faChevronDown];
        default:
            return ['text-neutral-700', faMinus];
    }
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
            <RewardAlert v-show="grid.md" />

            <Navigation />

            <ResetPassword
                v-if="$page.props.flash.data"
                :email="$page.props.flash.data.email"
                :token="$page.props.flash.data.token"
            />

            <div v-if="characters.data.length > 0" class="mt-4 font-bold">
                <table class="rtl table border-collapse">
                    <thead>
                        <tr class="bg-base-100">
                            <th class="hidden w-0 md:table-cell"></th>
                            <th class="w-0 text-right">Score</th>
                            <th class="hidden w-0 md:table-cell"></th>
                            <th></th>
                            <th class="w-0"></th>
                            <th class="w-0">Rank</th>
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
                                :class="{
                                    'bg-base-100 opacity-50':
                                        character.is_hidden,
                                }"
                            >
                                <td
                                    class="hidden p-0 px-2 text-center md:table-cell"
                                    :class="{
                                        'bg-base-200': !character.is_hidden,
                                    }"
                                >
                                    <a
                                        v-if="character.uid"
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
                                                    route('user.setting.extras')
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
                                    class="ltr grid grid-rows-2 p-0 px-2 py-3"
                                    :class="{
                                        'cursor-pointer':
                                            character.statistics &&
                                            character.user_id !== null,
                                    }"
                                    @click="
                                        character.statistics &&
                                        character.user_id !== null
                                            ? toggle(key)
                                            : null
                                    "
                                >
                                    <span class="truncate">
                                        <FontAwesomeIcon
                                            v-if="
                                                character.statistics &&
                                                character.user_id !== null
                                            "
                                            class="mr-1.5 rounded-sm border border-neutral-700 bg-base-100 !align-middle"
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
                                                    characters.meta
                                                        .current_page === 1 &&
                                                    key === 0,
                                                '!text-silver':
                                                    characters.meta
                                                        .current_page === 1 &&
                                                    key === 1,
                                                '!text-bronze':
                                                    characters.meta
                                                        .current_page === 1 &&
                                                    key === 2,
                                            }"
                                            :title="character.name"
                                            >{{
                                                character.name ?? 'Anonymous'
                                            }}</span
                                        >
                                    </span>

                                    <span
                                        class="mt-0.5 w-max select-none text-xs font-light text-neutral-500"
                                        title="Last active"
                                        >{{
                                            character.formatted_last_seen_at ??
                                            'N/A'
                                        }}</span
                                    >
                                </td>

                                <td class="ltr px-2">
                                    <div class="indicator align-middle">
                                        <img
                                            class="h-6 w-6 select-none self-center rounded-full bg-base-100 text-[0rem]"
                                            :src="
                                                character.avatar_url ??
                                                'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
                                            "
                                            alt="Avatar"
                                            loading="lazy"
                                            onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='"
                                        />

                                        <span
                                            v-if="
                                                character.role ===
                                                    'supporter' &&
                                                character.is_highest_score
                                            "
                                            class="indicator-item indicator-end indicator-middle"
                                        >
                                            <FontAwesomeLayers>
                                                <FontAwesomeIcon
                                                    class="z-[1] text-supporter opacity-80"
                                                    :icon="faHeart"
                                                    size="lg"
                                                    transform="left-3 down-1 shrink-6"
                                                />

                                                <FontAwesomeIcon
                                                    class="text-base-300"
                                                    :icon="faCircle"
                                                    size="lg"
                                                    transform="left-3 down-1"
                                                />
                                            </FontAwesomeLayers>
                                        </span>
                                    </div>
                                </td>

                                <td
                                    v-if="
                                        characters.meta.current_page === 1 &&
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

                                <td
                                    v-else
                                    class="text-center text-[1rem] font-bold"
                                >
                                    {{ getRank(key, 1) }}
                                </td>

                                <td class="hidden p-0 md:table-cell">
                                    <span class="ltr">
                                        <FontAwesomeIcon
                                            class="p-0 pl-4 !align-middle"
                                            :class="
                                                getMovementRank(
                                                    getCachedRank(
                                                        character.id,
                                                    ) - getRank(key),
                                                )[0]
                                            "
                                            :icon="
                                                getMovementRank(
                                                    getCachedRank(
                                                        character.id,
                                                    ) - getRank(key),
                                                )[1]
                                            "
                                            fixed-width
                                        />
                                    </span>
                                </td>
                            </tr>

                            <tr
                                v-if="
                                    key === open &&
                                    character.statistics &&
                                    character.user_id !== null
                                "
                            >
                                <td class="p-0" :colspan="grid.md ? 4 : 2">
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

            <Pagination :meta="characters.meta" />
        </div>
    </DefaultLayout>
</template>
