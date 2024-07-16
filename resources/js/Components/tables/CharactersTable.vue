<script setup>
import { ref } from 'vue';
import { useGrid } from 'vue-screen';
import { BaseTable } from '@/Components/base';
import { LinkBadge } from '@/Components/features/character';
import { StatisticsTable } from '@/Components/tables';
import {
    faAngleDown,
    faAngleUp,
    faChevronDown,
    faChevronUp,
    faCircle,
    faHeart,
    faLock,
    faMinus,
    faTrophy,
} from '@fortawesome/free-solid-svg-icons';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    characters: {
        type: Object,
        required: true,
    },
});

const open = ref(null);
const grid = useGrid('tailwind');

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
    return Object.keys(props.characters.ranking).find(
        (key) => props.characters.ranking[key] === id,
    );
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
    <BaseTable dir="rtl">
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
                        'bg-base-100 opacity-50': character.is_hidden,
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
                        {{ character.formatted_score ?? '&dash;' }}
                    </td>

                    <td class="hidden text-right md:table-cell">
                        <template
                            v-if="
                                $page.props.auth.user !== null &&
                                $page.props.auth.user.connections.some(
                                    (e) => e.pivot.identifier === character.uid,
                                )
                            "
                        >
                            <Link
                                v-if="
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.characters.some(
                                        (e) => e.id === character.id,
                                    )
                                "
                                class="badge badge-primary badge-outline badge-sm select-none font-light uppercase"
                                :href="route('user.setting.characters')"
                            >
                                You
                            </Link>

                            <template v-else>
                                <Link
                                    v-if="
                                        $page.props.roles.includes('member') &&
                                        $page.props.auth.user.characters
                                            .length > 0
                                    "
                                    dir="ltr"
                                    class="badge badge-error badge-outline badge-sm select-none font-light uppercase"
                                    :href="route('user.setting.extras')"
                                >
                                    <FontAwesomeIcon
                                        class="mr-1"
                                        :icon="faLock"
                                        size="2xs"
                                        fixed-width
                                    />

                                    Link
                                </Link>

                                <LinkBadge v-else :id="character.id" />
                            </template>
                        </template>
                    </td>

                    <td
                        dir="ltr"
                        class="grid grid-rows-2 p-0 px-2 py-3 text-left"
                        :class="{
                            'cursor-pointer': character.statistics,
                        }"
                        @click="character.statistics ? toggle(key) : null"
                    >
                        <span class="truncate">
                            <FontAwesomeIcon
                                v-if="character.statistics"
                                class="mr-1.5 rounded-sm border border-neutral-700 bg-base-100 !align-middle"
                                :icon="key === open ? faAngleUp : faAngleDown"
                                size="sm"
                                fixed-width
                            />

                            <span
                                class="text-neutral-400"
                                :class="{
                                    '!text-rank-gold':
                                        characters.meta.current_page === 1 &&
                                        key === 0,
                                    '!text-rank-silver':
                                        characters.meta.current_page === 1 &&
                                        key === 1,
                                    '!text-rank-bronze':
                                        characters.meta.current_page === 1 &&
                                        key === 2,
                                }"
                                :title="character.name"
                                >{{ character.name ?? 'Anonymous' }}</span
                            >
                        </span>

                        <span
                            class="mt-0.5 w-max select-none text-xs font-light text-neutral-500"
                            title="Last active"
                            >{{
                                character.formatted_last_seen_at ?? 'n/a'
                            }}</span
                        >
                    </td>

                    <td dir="ltr" class="px-2">
                        <div class="indicator align-middle">
                            <img
                                class="h-6 w-6 select-none self-center rounded-full bg-base-100 text-[0rem]"
                                :src="
                                    character.user.gravatar_url ??
                                    character.avatar_url ??
                                    'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
                                "
                                alt="Avatar"
                                loading="lazy"
                                onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='"
                            />

                            <span
                                v-if="
                                    character.user.role === 'supporter' &&
                                    character.is_highest_score
                                "
                                class="indicator-item indicator-start indicator-bottom cursor-pointer"
                                title="Supporter"
                            >
                                <FontAwesomeLayers>
                                    <FontAwesomeIcon
                                        class="z-10 text-role-supporter opacity-80"
                                        :icon="faHeart"
                                        size="lg"
                                        transform="right-6 shrink-6"
                                    />

                                    <FontAwesomeIcon
                                        class="text-base-300"
                                        :icon="faCircle"
                                        size="lg"
                                        transform="right-6"
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
                                'text-rank-gold': key === 0,
                                'text-rank-silver': key === 1,
                                'text-rank-bronze': key === 2,
                            }"
                            :icon="faTrophy"
                            size="lg"
                            fixed-width
                        />
                    </td>

                    <td v-else class="text-center text-[1rem] font-bold">
                        {{ getRank(key, 1) }}
                    </td>

                    <td class="hidden pr-0 md:table-cell">
                        <FontAwesomeIcon
                            class="!align-middle"
                            :class="
                                getMovementRank(
                                    getCachedRank(character.id) - getRank(key),
                                )[0]
                            "
                            :icon="
                                getMovementRank(
                                    getCachedRank(character.id) - getRank(key),
                                )[1]
                            "
                            fixed-width
                        />
                    </td>
                </tr>

                <tr v-if="character.statistics && key === open">
                    <td class="p-0" :colspan="grid.md ? 4 : 2">
                        <StatisticsTable :statistics="character.statistics" />
                    </td>
                </tr>
            </template>
        </tbody>
    </BaseTable>
</template>
