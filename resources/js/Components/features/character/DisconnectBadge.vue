<script setup>
import { BaseBadge } from '@/Components/base';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    connection_id: props.id,
});

const disconnect = () => {
    form.delete(route('connection.destroy'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <BaseBadge
        class="text-xs badge-md badge-error"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="disconnect"
    >
        Disconnect
    </BaseBadge>
</template>
