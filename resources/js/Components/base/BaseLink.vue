<script setup>
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    size: {
        type: String,
        default: 'xs',
    },
});
</script>

<template>
    <a class="group" :href="href" target="_blank">
        <slot />
        <FontAwesomeIcon
            class="!align-middle group-[.underlined-link]:mx-1"
            :icon="faArrowUpRightFromSquare"
            :size="size"
        />
    </a>
</template>
