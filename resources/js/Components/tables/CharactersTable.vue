<script setup>
import { BaseTable } from '@/Components/base';
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
    faMinus,
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
            <tr class="select-none [&>th]:pt-0">
                <th class="w-0 text-right">Score</th>
                <th></th>
                <th class="hidden md:table-cell"></th>
                <th class="w-0"></th>
                <th class="w-0">Rank</th>
                <th class="hidden w-0 md:table-cell"></th>
            </tr>
        </thead>

        <tbody
            class="bg-base-300"
            :class="{
                'bg-gradient-to-t from-[#202020] from-20% to-45% select-none [&>tr:nth-child(n+4)]:opacity-0':
                    !characters.meta,
            }"
        >
            <template
                v-for="(character, key) in characters.data"
                :key="character.id"
            >
                <tr
                    class="border-base-100 [&:not(:first-child)]:!border-t-4"
                    :class="{
                        'bg-base-100 opacity-50': character.is_hidden,
                        'text-gold': key === 0,
                        'text-silver': key === 1,
                        'text-bronze': key === 2,
                    }"
                >
                    <td
                        class="text-right text-lg font-light tabular-nums"
                        :class="{
                            'select-none': !character.formatted_score,
                        }"
                    >
                        {{ character.formatted_score ?? '&dash;' }}
                    </td>

                    <td class="hidden w-10 md:table-cell">
                        <a
                            v-if="
                                character.guid &&
                                ($page.props.auth.user === null ||
                                    $page.props.auth.user.connections.find(
                                        (e) =>
                                            e.pivot.identifier !==
                                            character.guid,
                                    ))
                            "
                            :href="`https://steamcommunity.com/profiles/${character.guid}`"
                            target="_blank"
                        >
                            <FontAwesomeIcon
                                class="!align-middle text-neutral-400 opacity-30 transition ease-in-out hover:opacity-100"
                                :icon="faSteam"
                                size="xl"
                                title="Steam Community Profile"
                            />
                        </a>

                        <template
                            v-if="
                                $page.props.auth.user !== null &&
                                $page.props.auth.user.connections.some(
                                    (e) =>
                                        e.pivot.identifier === character.guid,
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
                                class="badge badge-primary badge-soft badge-sm font-light uppercase select-none"
                                :href="route('user.setting.characters')"
                            >
                                You
                            </Link>

                            <template v-else>
                                <Link
                                    v-if="
                                        $page.props.auth.role === 'member' &&
                                        $page.props.auth.user.characters
                                            .length > 0
                                    "
                                    dir="ltr"
                                    class="badge badge-error badge-soft badge-sm gap-1.5 font-light uppercase select-none"
                                    :href="route('user.setting.extras')"
                                >
                                    Link
                                </Link>

                                <LinkBadge v-else :id="character.id" />
                            </template>
                        </template>
                    </td>

                    <td
                        dir="ltr"
                        class="grid grid-flow-col grid-cols-1 grid-rows-2 p-0 px-2 py-3 text-left"
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
                        <span class="truncate">
                            <FontAwesomeIcon
                                v-if="character.relations.statistics.length > 0"
                                class="bg-base-100 mr-1.5 border border-neutral-700 !align-middle text-neutral-400"
                                :icon="key === open ? faAngleUp : faAngleDown"
                                size="xs"
                                fixed-width
                            />

                            <span
                                :class="{
                                    'select-none':
                                        character.relations.statistics.length >
                                        0,
                                }"
                                :title="character.name"
                            >
                                {{ character.name ?? 'Anonymous' }}
                            </span>
                        </span>

                        <span
                            class="mt-0.5 w-max text-xs font-light text-neutral-600 select-none"
                            title="Last active"
                            >{{
                                character.formatted_last_seen_at ?? 'n/a'
                            }}</span
                        >
                    </td>

                    <td dir="ltr" class="px-1.5">
                        <div
                            v-if="!character.is_hidden"
                            class="indicator align-middle"
                        >
                            <div class="bg-base-100 h-7 w-7 rounded-full">
                                <img
                                    class="h-7 w-7 self-center rounded-full text-[0rem] select-none"
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
                                class="indicator-item indicator-bottom indicator-center"
                                title="Supporter"
                            >
                                <FontAwesomeLayers>
                                    <FontAwesomeIcon
                                        class="text-supporter z-10 opacity-80"
                                        :icon="faHeart"
                                        size="lg"
                                        transform="shrink-6"
                                    />

                                    <FontAwesomeIcon
                                        class="text-base-300"
                                        :icon="faCircle"
                                        size="lg"
                                    />
                                </FontAwesomeLayers>
                            </span>
                        </div>
                    </td>

                    <td v-if="key in [0, 1, 2]" class="text-center">
                        <FontAwesomeIcon
                            class="!align-middle"
                            :icon="faTrophy"
                            size="xl"
                            fixed-width
                        />
                    </td>

                    <td v-else class="text-center text-base tabular-nums">
                        {{ key + 1 }}
                    </td>

                    <td
                        class="hidden md:table-cell"
                        :class="{
                            'bg-base-200': !character.is_hidden,
                        }"
                    >
                        <FontAwesomeIcon
                            v-if="
                                getCachedRank(character.id) || !characters.meta
                            "
                            class="!align-middle"
                            :class="
                                getMovementRank(
                                    getCachedRank(character.id) - key,
                                )[0]
                            "
                            :icon="
                                getMovementRank(
                                    getCachedRank(character.id) - key,
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
                    <td class="bg-base-100 p-0 pl-2" colspan="3">
                        <StatisticsTable
                            :statistics="character.relations.statistics"
                        />
                    </td>
                </tr>
            </template>
        </tbody>
    </BaseTable>
</template>
