<script setup>
import {
    faBars,
    faFile,
    faRankingStar,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link, usePage } from '@inertiajs/vue3';

const icon = {
    bars: faBars,
    file: faFile,
}[usePage().props.icon];
</script>

<template>
    <div v-if="$page.props.name" class="flex bg-base-300 text-sm">
        <div class="container breadcrumbs mx-auto py-4">
            <ul>
                <li>
                    <Link class="underlined-link" :href="route('home')">
                        <FontAwesomeIcon
                            class="mr-1.5"
                            :icon="faRankingStar"
                            size="sm"
                            fixed-width
                        />
                        Leaderboard
                    </Link>
                </li>

                <li class="text-neutral-300">
                    <FontAwesomeIcon
                        v-if="icon"
                        class="mr-1.5"
                        :icon="icon"
                        size="sm"
                        fixed-width
                    />
                    {{ $page.props.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
