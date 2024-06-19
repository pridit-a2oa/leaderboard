<script setup>
import { BaseError, BaseInput } from '@/Components/base';

defineProps({
    classes: {
        type: String,
    },
    error: {
        type: String,
    },
});
</script>

<template>
    <label class="flex items-center bg-base-200" :class="classes">
        <slot />

        <BaseInput v-bind="$attrs" />
    </label>

    <BaseError v-if="error" :message="error" />
</template>
