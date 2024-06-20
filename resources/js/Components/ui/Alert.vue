<script setup>
defineProps({
    type: {
        type: String,
        required: true,
        validator(value) {
            return ['danger', 'info', 'success', 'warning'].includes(value);
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
        class="alert mb-4 flex !w-full rounded-md px-6 py-2.5 text-sm font-medium text-neutral-800"
        :class="types[type]"
    >
        <span class="w-full text-center">{{ message }}</span>
    </div>
</template>
