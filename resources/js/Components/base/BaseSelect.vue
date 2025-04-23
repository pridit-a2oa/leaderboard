<script setup>
import { useId } from 'vue';

defineOptions({
    inheritAttrs: false,
});

defineProps({
    id: {
        type: String,
        default() {
            return `select-input-${useId()}`;
        },
    },
});

const model = defineModel({
    type: [String, Number, Boolean],
});
</script>

<template>
    <div :class="$attrs.class">
        <select
            :id="id"
            ref="input"
            v-model="model"
            v-bind="{ ...$attrs, class: null }"
            class="select select-bordered bg-base-200 w-full"
            :class="{ 'input-error': error }"
        >
            <slot />
        </select>
    </div>
</template>
