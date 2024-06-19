<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="mt-2">
        <p class="text-sm text-red-500">
            {{ message }}
        </p>
    </div>
</template>
