<script setup>
import { BaseError, BaseInput } from '@/Components/base';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { ref } from 'vue';

const input = ref(null);
const passwordVisible = ref(false);

defineProps({
    classes: {
        type: String,
    },
    error: {
        type: String,
    },
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <label class="input flex items-center gap-3 bg-base-200" :class="classes">
        <slot />

        <BaseInput
            ref="input"
            v-bind="$attrs"
            :type="passwordVisible ? 'text' : $attrs['type']"
        />

        <FontAwesomeIcon
            v-if="$attrs['type'] === 'password'"
            class="cursor-pointer text-neutral-400"
            :icon="passwordVisible ? faEye : faEyeSlash"
            size="sm"
            @click="
                $event.preventDefault();
                passwordVisible = !passwordVisible;
            "
        />
    </label>

    <BaseError v-if="error" :message="error" />
</template>
