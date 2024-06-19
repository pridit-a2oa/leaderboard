<script setup>
import { BaseLink } from '@/Components/base';
</script>

<template>
    <BaseLink class="btn no-animation" v-bind="$attrs">
        <slot />
    </BaseLink>
</template>
