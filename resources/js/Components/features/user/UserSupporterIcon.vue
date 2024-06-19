<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { faHeart, faHeartBroken } from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';

const supporter = usePage().props.roles.includes('supporter');
</script>

<template>
    <Link
        class="indicator-item"
        :href="route('user.setting.extras')"
        :title="supporter ? 'Thanks for being a supporter!' : ':('"
    >
        <FontAwesomeLayers fixed-width>
            <FontAwesomeIcon
                class="z-10 text-neutral-700"
                :class="{
                    'text-supporter': supporter,
                }"
                :icon="supporter ? faHeart : faHeartBroken"
            />

            <FontAwesomeIcon
                class="text-base-100"
                :icon="faHeart"
                size="2xl"
                transform="left-3 down-1"
            />
        </FontAwesomeLayers>
    </Link>
</template>
