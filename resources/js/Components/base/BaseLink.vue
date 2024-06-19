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
        required: false,
    },
    size: {
        type: String,
        default: 'xs',
    },
});
</script>

<template>
    <a class="group" :class="class" :href="href" target="_blank">
        <slot />
        <FontAwesomeIcon
            class="!align-middle group-[.underlined-link]:mx-1"
            :icon="faArrowUpRightFromSquare"
            :size="size"
        />
    </a>
</template>
