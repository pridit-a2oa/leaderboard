<script setup>
import { BaseButton } from '@/Components/base';
</script>

<template>
    <BaseButton class="bg-red-500 text-black hover:bg-red-500" v-bind="$attrs">
        <slot />
    </BaseButton>
</template>
