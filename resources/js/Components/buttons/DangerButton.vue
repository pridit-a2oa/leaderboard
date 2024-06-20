<script setup>
import { BaseButton } from '@/Components/base';
</script>

<template>
    <BaseButton
        class="bg-red-500 text-neutral-800 hover:bg-red-500"
        v-bind="$attrs"
    >
        <slot />
    </BaseButton>
</template>
