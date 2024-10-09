<script setup>
import { BaseError, BaseSelect } from '@/Components/base';

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
    <BaseSelect v-bind="$attrs" :class="classes">
        <slot />
    </BaseSelect>

    <BaseError v-if="error" :message="error" />
</template>
