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
import { usePage } from '@inertiajs/vue3';

defineProps({
    user: {
        type: Object,
    },
    size: {
        type: String,
    },
});

const rewarded = computed(() => {
    return (
        usePage().props.auth.user.connections.length !== 0 &&
        usePage().props.auth.user.characters.length !== 0
    );
});
</script>

<template>
    <FontAwesomeLayers class="indicator mr-1">
        <FontAwesomeIcon :icon="faPersonRifle" fixed-width />
        <FontAwesomeIcon
            v-if="user !== null"
            :icon="rewarded ? faCircleCheck : faCircleXmark"
            class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 p-0 py-0.5"
            :class="rewarded ? 'text-green-700' : 'text-red-500'"
            size="sm"
            transform="shrink-2"
            fixed-width
        />
    </FontAwesomeLayers>
</template>
