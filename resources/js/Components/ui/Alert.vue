<script setup>
defineProps({
    type: {
        type: String,
        validator(value) {
            return ['error', 'info', 'success', 'warning'].includes(value);
        },
    },
    message: {
        type: String,
        required: true,
    },
});

const types = {
    error: 'alert-error',
    info: 'alert-info',
    success: 'alert-success',
    warning: 'alert-warning',
};
</script>

<template>
    <div
        role="alert"
        class="mb-4 alert flex !w-full rounded-md px-6 py-2.5 text-sm font-medium text-neutral-800 select-none"
        :class="type ? types[type] : ''"
    >
        <span class="w-full text-center">{{ message }}</span>
    </div>
</template>
