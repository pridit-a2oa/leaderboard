<script setup>
import { BaseButton } from '@/Components/base';
</script>

<template>
    <BaseButton
        class="no-animation btn-sm bg-green-800 font-normal text-neutral-200 hover:bg-green-700"
        v-bind="$attrs"
    >
        <slot />
    </BaseButton>
</template>
