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
            class="select-bordered select w-full bg-base-200"
            :class="{ 'input-error': error }"
        >
            <slot />
        </select>
    </div>
</template>
