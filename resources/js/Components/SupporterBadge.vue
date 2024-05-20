<script setup>
import { faHeart } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <span
        class="badge indicator-item badge-secondary badge-sm p-0 px-1 py-2"
        title="Thanks for being a supporter!"
    >
        <FontAwesomeIcon class="text-supporter" :icon="faHeart" />
    </span>
</template>
