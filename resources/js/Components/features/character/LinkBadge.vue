<script setup>
import { BaseBadge } from '@/Components/base';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
    },
});

const form = useForm({
    character_id: props.id,
});

const linkCharacter = () => {
    form.post(route('character.link.store'), {
        preserveScroll: true,
        preserveState: false,
    });
};
</script>

<template>
    <BaseBadge
        dir="ltr"
        class="badge-success badge-sm !badge-outline cursor-pointer gap-1.5"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        v-on="id ? { click: linkCharacter } : {}"
        dusk="link-button"
    >
        <FontAwesomeIcon :icon="faUser" size="xs" />
        Link
    </BaseBadge>
</template>
