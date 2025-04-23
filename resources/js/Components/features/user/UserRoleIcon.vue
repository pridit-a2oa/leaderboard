<script setup>
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
            ($page.props.auth.role === 'supporter' &&
                'Thanks for being a supporter!') ||
            ''
        "
    >
        <FontAwesomeLayers v-if="icon[$page.props.auth.role]" fixed-width>
            <FontAwesomeIcon
                class="z-10 text-neutral-600"
                :class="{
                    'text-supporter': $page.props.auth.role === 'supporter',
                }"
                :icon="icon[$page.props.auth.role]"
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
