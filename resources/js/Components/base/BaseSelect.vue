<script setup>
import { ref, watch } from 'vue';
import { v4 as uuid } from 'uuid';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    id: {
        type: String,
        default() {
            return `select-input-${uuid()}`;
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
            class="select select-bordered w-full bg-base-200"
            :class="{ 'input-error': error }"
        >
            <slot />
        </select>
    </div>
</template>
