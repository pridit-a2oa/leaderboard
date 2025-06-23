<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faCircle,
    faCog,
    faHeart,
    faHeartBroken,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';

library.add(faCog, faHeart, faHeartBroken);
</script>

<template>
    <div
        class="indicator-item cursor-default"
        :title="
            ($page.props.auth.role.name === 'supporter' &&
                'Thanks for being a supporter!') ||
            ''
        "
    >
        <FontAwesomeLayers v-if="$page.props.auth.role.icon" fixed-width>
            <FontAwesomeIcon
                class="z-10 text-neutral-500"
                :style="{ color: $page.props.auth.role.color }"
                :icon="$page.props.auth.role.icon"
            />

            <FontAwesomeIcon
                class="text-base-100"
                :icon="faCircle"
                size="2xl"
                transform="left-2"
            />
        </FontAwesomeLayers>
    </div>
</template>
