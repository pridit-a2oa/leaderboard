<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="mt-2">
        <p class="text-sm text-error">
            {{ message }}
        </p>
    </div>
</template>
