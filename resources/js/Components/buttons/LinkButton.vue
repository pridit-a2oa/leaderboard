<script setup>
import { faArrowRightLong } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <button class="underlined-link">
        <slot /><FontAwesomeIcon
            class="ml-1 !align-middle"
            :icon="faArrowRightLong"
            size="xs"
        />
    </button>
</template>
