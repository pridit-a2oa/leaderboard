<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <a :href="href" class="underlined-link" target="_blank">
        <slot />

        <FontAwesomeIcon
            class="mx-1 !align-middle"
            :icon="faArrowUpRightFromSquare"
            size="2xs"
        />
    </a>
</template>
