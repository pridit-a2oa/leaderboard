<script setup>
import { BaseCheckbox, BaseError } from '@/Components/base';

defineProps({
    error: {
        type: String,
    },
});
</script>

<template>
    <label class="label cursor-pointer justify-normal">
        <BaseCheckbox v-bind="$attrs" />

        <span class="text-sm">
            <slot />
        </span>
    </label>

    <BaseError class="mt-2" :message="error" />
</template>
