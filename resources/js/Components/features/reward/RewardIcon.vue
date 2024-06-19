<script setup>
import { computed } from 'vue';
import {
    faPersonRifle,
    faCircleCheck,
    faCircleXmark,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const rewarded = computed(() => {
    return (
        props.user.connections.length !== 0 &&
        props.user.characters.length !== 0
    );
});
</script>

<template>
    <FontAwesomeLayers class="indicator mr-1">
        <FontAwesomeIcon :icon="faPersonRifle" fixed-width />
        <FontAwesomeIcon
            v-show="user !== null"
            :icon="rewarded ? faCircleCheck : faCircleXmark"
            class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 p-0 py-0.5"
            :class="rewarded ? 'text-green-700' : 'text-red-500'"
            size="sm"
            transform="shrink-2"
            fixed-width
        />
    </FontAwesomeLayers>
</template>
