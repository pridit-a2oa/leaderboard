<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <span
        v-if="value && value !== '0'"
        class="rounded bg-base-100 px-1.5 text-xs tabular-nums outline outline-1 outline-neutral-500 outline-solid"
        >{{ value }}</span
    >
</template>
