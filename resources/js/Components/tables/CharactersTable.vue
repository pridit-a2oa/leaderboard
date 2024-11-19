<script setup>
import { BaseTable } from '@/Components/base';
import { CopyButton } from '@/Components/buttons';
import { LinkBadge } from '@/Components/features/character';
import { StatisticsTable } from '@/Components/tables';
import { isHighestScore } from '@/utils';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import {
    faAngleDown,
    faAngleUp,
    faChevronDown,
    faChevronUp,
    faCircle,
    faHand,
    faHeart,
    faLock,
    faMinus,
    faTriangleExclamation,
    faTrophy,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { ref } from 'vue';

const props = defineProps({
    characters: {
        type: Object,
        required: true,
    },
});

const open = ref(null);

function toggle(id) {
    open.value = open.value === id ? null : id;
}

function getRank(key, added) {
    return (
        key +
        ((props.characters.meta?.current_page - 1) *
            props.characters.meta?.per_page +
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
            <tr class="bg-base-100 [&>th]:pt-0">
                <th class="w-0 text-right">Score</th>
                <th></th>
                <th class="w-0"></th>
                <th class="w-0">Rank</th>
                <th class="hidden w-0 md:table-cell"></th>
            </tr>
        </thead>

        <tbody
            class="bg-base-300"
            :class="{
                'select-none bg-gradient-to-t from-neutral-800 from-20% to-45% [&>tr:nth-child(n+4)]:opacity-0':
                    !characters.meta,
            }"
        >
            <template
                v-for="(character, key) in characters.data"
                :key="character.id"
            >
                <tr
                    class="group !border-b-4 border-base-100 [&:not(:first-child)]:!border-t-4"
                    :class="{
                        'bg-base-100 opacity-50': character.is_hidden,
                        'text-rank-gold':
                            key === 0 &&
                            (characters.meta?.current_page === 1 ||
                                !characters.meta),
                        'text-rank-silver':
                            key === 1 &&
                            (characters.meta?.current_page === 1 ||
                                !characters.meta),
                        'text-rank-bronze':
                            key === 2 &&
                            (characters.meta?.current_page === 1 ||
                                !characters.meta),
                    }"
                >
                    <td class="text-right text-lg font-light">
                        {{ character.formatted_score ?? '&dash;' }}
                    </td>

                    <td
                        dir="ltr"
                        class="grid grid-flow-col grid-cols-1 grid-rows-2 p-0 px-2 py-3 text-left"
                    >
                        <span
                            class="truncate"
                            :class="{
                                'cursor-pointer':
                                    character.relations.statistics.length > 0,
                            }"
                            @click="
                                character.relations.statistics.length > 0
                                    ? toggle(key)
                                    : null
                            "
                        >
                            <FontAwesomeIcon
                                v-if="character.relations.statistics.length > 0"
                                class="mr-1.5 rounded-sm border border-neutral-700 bg-base-100 !align-middle text-neutral-400"
                                :icon="key === open ? faAngleUp : faAngleDown"
                                size="sm"
                                fixed-width
                            />

                            <span :title="character.name">
                                {{ character.name ?? 'Anonymous'
                                }}<a
                                    v-if="character.guid"
                                    :href="`https://steamcommunity.com/profiles/${character.guid}`"
                                    target="_blank"
                                    @click.stop
                                >
                                    <FontAwesomeIcon
                                        class="ml-1 !align-middle text-neutral-400 opacity-0 transition ease-in-out group-hover:opacity-100"
                                        :icon="faSteam"
                                        title="Steam Community Profile"
                                        fixed-width
                                    />
                                </a>
                            </span>
                        </span>

                        <span
                            class="mt-0.5 w-max select-none text-xs font-light text-neutral-500/80"
                            title="Last active"
                            >{{
                                character.formatted_last_seen_at ?? 'n/a'
                            }}</span
                        >

                        <div
                            class="col-span-1 row-span-2 ml-4 hidden self-center md:table-cell"
                        >
                            <template
                                v-if="
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.connections.some(
                                        (e) =>
                                            e.pivot.identifier ===
                                            character.guid,
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
                                            $page.props.auth.role ===
                                                'member' &&
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

                            <template v-else>
                                <FontAwesomeIcon
                                    v-if="character.is_muted"
                                    class="ml-2 !align-middle text-warning"
                                    :icon="faTriangleExclamation"
                                    size="lg"
                                    title="This player is chat banned"
                                    fixed-width
                                />

                                <CopyButton
                                    v-else
                                    class="opacity-[.01] transition ease-in-out group-hover:opacity-100"
                                    :value="character.guid ?? ''"
                                />
                            </template>
                        </div>
                    </td>

                    <td dir="ltr" class="px-1.5">
                        <div class="indicator align-middle">
                            <div class="h-7 w-7 rounded-full bg-base-100">
                                <img
                                    class="h-7 w-7 select-none self-center rounded-full text-[0rem]"
                                    :src="
                                        character.relations.user.gravatar_url ??
                                        character.avatar_url ??
                                        'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
                                    "
                                    alt="Avatar"
                                    loading="lazy"
                                    onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='"
                                />
                            </div>

                            <span
                                v-if="
                                    character.relations.user.role ===
                                        'supporter' &&
                                    isHighestScore(characters.data, character)
                                "
                                class="indicator-item indicator-start indicator-bottom"
                                title="Supporter"
                            >
                                <FontAwesomeLayers>
                                    <FontAwesomeIcon
                                        class="z-10 text-role-supporter opacity-80"
                                        :icon="faHeart"
                                        size="lg"
                                        transform="right-8 shrink-6"
                                    />

                                    <FontAwesomeIcon
                                        class="text-base-300"
                                        :icon="faCircle"
                                        size="lg"
                                        transform="right-8"
                                    />
                                </FontAwesomeLayers>
                            </span>
                        </div>
                    </td>

                    <td
                        v-if="
                            key in [0, 1, 2] &&
                            (characters.meta?.current_page === 1 ||
                                !characters.meta)
                        "
                        class="text-center"
                    >
                        <FontAwesomeIcon
                            class="!align-middle"
                            :icon="faTrophy"
                            size="xl"
                            fixed-width
                        />
                    </td>

                    <td v-else class="text-center text-[1rem] font-bold">
                        {{ getRank(key, 1) || key + 1 }}
                    </td>

                    <td
                        class="hidden md:table-cell"
                        :class="{
                            'bg-base-200/75': !character.is_hidden,
                        }"
                    >
                        <FontAwesomeIcon
                            v-if="
                                getCachedRank(character.id) || !characters.meta
                            "
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

                        <FontAwesomeIcon
                            v-else
                            class="!align-middle text-teal-500"
                            :icon="faHand"
                            title="I'm new/returning"
                            transform="rotate-45"
                            fixed-width
                        />
                    </td>
                </tr>

                <tr
                    v-if="
                        character.relations.statistics.length > 0 &&
                        key === open
                    "
                >
                    <td class="p-0" :colspan="2">
                        <StatisticsTable
                            :statistics="character.relations.statistics"
                        />
                    </td>
                </tr>
            </template>
        </tbody>
    </BaseTable>
</template>
