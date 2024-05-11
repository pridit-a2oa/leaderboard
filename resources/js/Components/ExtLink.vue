<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';

const props = defineProps({
    class: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <a :href="href" class="btn no-animation" target="_blank">
        <font-awesome-icon :icon="icon" :class="class" size="sm" />
        <slot />
        <font-awesome-icon :icon="faArrowUpRightFromSquare" size="xs" />
    </a>
</template>
