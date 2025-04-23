<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="mt-2">
        <p class="text-error text-sm">
            {{ message }}
        </p>
    </div>
</template>
