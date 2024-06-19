<script setup>
import { BaseBadge } from '@/Components/base';
import { faUserSlash } from '@fortawesome/free-solid-svg-icons';
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

const unlinkCharacter = () => {
    form.delete(route('character.link.destroy'), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <BaseBadge
        class="badge-warning"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="unlinkCharacter"
        dusk="unlink-button"
    >
        <FontAwesomeIcon :icon="faUserSlash" size="xs" fixed-width />
    </BaseBadge>
</template>
