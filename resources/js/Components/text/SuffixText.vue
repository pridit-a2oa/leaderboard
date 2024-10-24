<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <span
        v-if="value !== '0'"
        class="outline-solid rounded bg-base-100 px-1.5 text-xs outline outline-1 outline-neutral-500"
        >{{ value }}</span
    >
</template>
