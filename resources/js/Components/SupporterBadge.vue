<script setup>
import { faHeart } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <span
        class="indicator-item mr-1 mt-1 cursor-pointer rounded-full bg-base-100 p-0 px-1 py-1"
        title="Thanks for being a supporter!"
    >
        <FontAwesomeIcon class="text-supporter" :icon="faHeart" fixed-width />
    </span>
</template>
