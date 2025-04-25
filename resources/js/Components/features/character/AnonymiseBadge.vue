<script setup>
import { BaseBadge } from '@/Components/base';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },

    hidden: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    character_id: props.id,
});

const setVisibility = () => {
    form.patch(route('character.visibility'), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <BaseBadge
        class="w-10"
        :disabled="form.processing"
        @click="setVisibility"
        dusk="visibility-button"
    >
        <FontAwesomeIcon
            :class="{
                'opacity-60': hidden,
            }"
            :icon="hidden ? faEyeSlash : faEye"
            size="sm"
        />
    </BaseBadge>
</template>
