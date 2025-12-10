<script setup>
import {
    faCircleCheck,
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
        <FontAwesomeIcon :icon="faPersonRifle" size="lg" />
        <FontAwesomeIcon
            v-show="user !== null && rewarded"
            :icon="faCircleCheck"
            class="indicator-item rounded-full bg-base-200 p-0 py-0.5 text-success indicator-end indicator-bottom"
            transform="shrink-2"
        />
    </FontAwesomeLayers>
</template>
