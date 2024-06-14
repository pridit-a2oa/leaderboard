<script setup>
defineProps({
    type: {
        type: String,
        required: true,
    },
    message: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div
        role="alert"
        class="alert mb-4 flex !w-full rounded-md px-6 py-2.5 text-sm font-medium text-neutral-800"
        :class="`alert-${type}`"
    >
        <span class="w-full text-center">{{ message }}</span>
    </div>
</template>
