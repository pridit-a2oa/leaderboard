<script setup>
import { BaseBadge } from '@/Components/base';
import { faRotate } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    character_id: props.id,
});

const resetCharacter = () => {
    form.patch(route('character.reset'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <BaseBadge
        class="badge-error"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="resetCharacter"
        dusk="reset-button"
    >
        <FontAwesomeIcon :icon="faRotate" size="xs" fixed-width />
    </BaseBadge>
</template>
