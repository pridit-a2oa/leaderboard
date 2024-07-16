<script setup>
import { BaseLink } from '@/Components/base';
</script>

<template>
    <BaseLink class="underlined-link" rel="nofollow" v-bind="$attrs">
        <slot />
    </BaseLink>
</template>
