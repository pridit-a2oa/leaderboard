<script setup>
import { ref } from 'vue';
import { BaseError, BaseInput } from '@/Components/base';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';

const passwordVisible = ref(false);

defineProps({
    classes: {
        type: String,
    },
    error: {
        type: String,
    },
});
</script>

<template>
    <label
        class="input input-bordered flex items-center gap-3 bg-base-200"
        :class="classes"
    >
        <slot />

        <BaseInput
            v-bind="$attrs"
            :type="passwordVisible ? 'text' : $attrs['type']"
        />

        <FontAwesomeIcon
            v-if="$attrs['type'] === 'password'"
            class="cursor-pointer text-neutral-400"
            :icon="passwordVisible ? faEye : faEyeSlash"
            size="sm"
            fixed-width
            @click="
                $event.preventDefault();
                passwordVisible = !passwordVisible;
            "
        />
    </label>

    <BaseError v-if="error" :message="error" />
</template>
