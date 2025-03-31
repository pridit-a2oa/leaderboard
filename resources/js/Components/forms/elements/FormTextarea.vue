<script setup>
import { BaseError, BaseTextarea } from '@/Components/base';

defineProps({
    classes: {
        type: String,
    },
    error: {
        type: String,
    },
});
</script>

<template>
    <BaseTextarea class="!textarea-bordered" :class="classes" v-bind="$attrs" />

    <BaseError v-if="error" :message="error" />
</template>
