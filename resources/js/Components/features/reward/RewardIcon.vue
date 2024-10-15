<script setup>
import {
    faCircleCheck,
    faCircleXmark,
    faPersonRifle,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { computed } from 'vue';

const props = defineProps({
    user: {
        type: Object,
    },
});

const rewarded = computed(() => {
    if (props.user)
        return (
            props.user.connections.length !== 0 &&
            props.user.characters.length !== 0
        );
});
</script>

<template>
    <FontAwesomeLayers class="indicator">
        <FontAwesomeIcon :icon="faPersonRifle" fixed-width />
        <FontAwesomeIcon
            v-show="user !== null"
            :icon="rewarded ? faCircleCheck : faCircleXmark"
            class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 p-0 py-0.5"
            :class="rewarded ? 'text-success' : 'text-error'"
            size="sm"
            transform="shrink-2"
            fixed-width
        />
    </FontAwesomeLayers>
</template>
