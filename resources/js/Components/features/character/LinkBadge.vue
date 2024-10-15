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
    });
};
</script>

<template>
    <BaseBadge
        dir="ltr"
        class="badge-success badge-sm"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        v-on="id ? { click: linkCharacter } : {}"
        dusk="link-button"
    >
        <FontAwesomeIcon class="mr-1" :icon="faUser" size="2xs" fixed-width />

        Link
    </BaseBadge>
</template>
