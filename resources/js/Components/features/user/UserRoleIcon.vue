<script setup>
import {
    faCog,
    faHeart,
    faHeartBroken,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';

const icon = {
    'member': faHeartBroken,
    'supporter': faHeart,
    'admin': faCog,
};
</script>

<template>
    <div
        class="indicator-item cursor-default"
        :title="
            ($page.props.roles[0] === 'supporter' &&
                'Thanks for being a supporter!') ||
            ''
        "
    >
        <FontAwesomeLayers v-if="icon[$page.props.roles[0]]" fixed-width>
            <FontAwesomeIcon
                class="z-10 text-neutral-600"
                :class="{
                    'text-role-supporter': $page.props.roles[0] === 'supporter',
                }"
                :icon="icon[$page.props.roles[0]]"
            />

            <FontAwesomeIcon
                class="text-base-100"
                :icon="faHeart"
                size="2xl"
                transform="left-3 down-1"
            />
        </FontAwesomeLayers>
    </div>
</template>
