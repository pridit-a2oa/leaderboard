<script setup>
import BadgeButton from '@/Components/BadgeButton.vue';
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
    form.post(route('character.unlink'), {
        preserveScroll: true,
        preserveState: false,
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <BadgeButton
        class="badge-warning"
        :class="{
            'opacity-25': form.processing,
        }"
        :disabled="form.processing"
        @click="unlinkCharacter"
    >
        <FontAwesomeIcon :icon="faUserSlash" size="xs" fixed-width />
    </BadgeButton>
</template>
