<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        class="checkbox checkbox-xs bg-base-100 mr-1 rounded-[0.3rem]"
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
    />
</template>
