<script setup>
import BadgeButton from '@/Components/BadgeButton.vue';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },

    visible: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    character_id: props.id,
});

const setVisibility = () => {
    form.post(route('character.visibility'), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <BadgeButton
        :class="{
            'opacity-60': !visible,
        }"
        :disabled="form.processing"
        @click="setVisibility"
    >
        <FontAwesomeIcon
            :icon="visible ? faEye : faEyeSlash"
            size="xs"
            fixed-width
        />
    </BadgeButton>
</template>
