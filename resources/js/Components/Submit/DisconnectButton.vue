<script setup>
import BadgeButton from '@/Components/BadgeButton.vue';
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
    form.post(route('connection.disconnect'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <BadgeButton
        class="badge-error badge-md"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="disconnect"
    >
        Disconnect
    </BadgeButton>
</template>
