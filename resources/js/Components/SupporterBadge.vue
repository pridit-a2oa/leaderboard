<script setup>
import { usePage } from '@inertiajs/vue3';
import { faHeart, faHeartBroken } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const supporter = usePage().props.roles.includes('supporter');
</script>

<template>
    <span
        class="indicator-item mr-1 mt-1 cursor-pointer rounded-full bg-base-100 p-0 px-1 py-1"
        :title="supporter ? 'Thanks for being a supporter!' : ':('"
    >
        <FontAwesomeIcon
            class="text-neutral-700"
            :class="{
                'text-supporter': supporter,
            }"
            :icon="supporter ? faHeart : faHeartBroken"
            fixed-width
        />
    </span>
</template>
