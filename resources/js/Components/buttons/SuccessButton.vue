<script setup>
import { BaseButton } from '@/Components/base';
</script>

<template>
    <BaseButton class="btn-success no-animation btn-sm" v-bind="$attrs">
        <slot />
    </BaseButton>
</template>
