<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    error: {
        type: String,
    },
});

const model = defineModel({
    type: String,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        class="textarea bg-base-200 grow resize-none font-mono text-sm placeholder:text-neutral-500"
        :class="{
            'input-error': error,
        }"
        :title="error"
        v-model="model"
        ref="input"
    />
</template>
