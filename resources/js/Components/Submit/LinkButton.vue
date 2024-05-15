<script setup>
import BadgeButton from '@/Components/BadgeButton.vue';
import { faUser } from '@fortawesome/free-solid-svg-icons';
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

const linkCharacter = () => {
    form.post(route('character.link.store'), {
        preserveScroll: true,
        preserveState: false,
    });
};
</script>

<template>
    <BadgeButton
        class="badge-success badge-sm"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="linkCharacter"
    >
        <FontAwesomeIcon class="mr-1" :icon="faUser" size="2xs" fixed-width />

        Link
    </BadgeButton>
</template>
