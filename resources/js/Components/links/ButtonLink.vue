<script setup>
import { BaseLink } from '@/Components/base';
</script>

<template>
    <BaseLink class="btn font-normal" v-bind="$attrs">
        <slot />
    </BaseLink>
</template>
