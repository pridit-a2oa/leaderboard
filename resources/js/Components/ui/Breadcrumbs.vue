<script setup>
import {
    faBars,
    faFile,
    faRankingStar,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const icon = {
    bars: faBars,
    file: faFile,
};
</script>

<template>
    <div v-if="$page.props.name" class="bg-base-300 flex text-sm">
        <div class="breadcrumbs xs:px-0 container mx-auto py-3 select-none">
            <ul>
                <li>
                    <Link class="underlined-link" :href="route('home')">
                        <FontAwesomeIcon :icon="faRankingStar" />
                        Leaderboard
                    </Link>
                </li>

                <li class="text-neutral-300">
                    <FontAwesomeIcon
                        v-if="icon[$page.props.icon]"
                        class="mr-1.5 !cursor-default"
                        :icon="icon[$page.props.icon]"
                    />
                    {{ $page.props.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
