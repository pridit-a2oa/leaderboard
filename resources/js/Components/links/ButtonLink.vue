<script setup>
import { BaseLink } from '@/Components/base';
</script>

<template>
    <BaseLink class="btn" v-bind="$attrs">
        <slot />
    </BaseLink>
</template>
