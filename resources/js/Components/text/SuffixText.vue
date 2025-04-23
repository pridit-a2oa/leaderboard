<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <span
        v-if="value && value !== '0'"
        class="bg-base-100 rounded px-1.5 text-xs outline outline-1 outline-neutral-500 outline-solid"
        >{{ value }}</span
    >
</template>
