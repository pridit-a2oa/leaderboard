<script setup>
import { BaseCheckbox, BaseError } from '@/Components/base';

defineProps({
    error: {
        type: String,
    },
});
</script>

<template>
    <label class="label cursor-pointer">
        <BaseCheckbox
            class="checkbox checkbox-xs mr-2 rounded-[0.3rem]"
            v-bind="$attrs"
        />

        <span class="label-text">
            <slot />
        </span>
    </label>

    <BaseError class="mt-2" :message="error" />
</template>
