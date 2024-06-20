<script setup>
import { BaseButton } from '@/Components/base';
</script>

<template>
    <BaseButton
        class="bg-error text-neutral-800 hover:bg-error"
        v-bind="$attrs"
    >
        <slot />
    </BaseButton>
</template>
