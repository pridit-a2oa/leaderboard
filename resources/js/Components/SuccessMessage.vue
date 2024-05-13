<script setup>
import { faCircleCheck } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    message: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
    >
        <span class="flex-1 self-center text-sm font-semibold text-success">
            <FontAwesomeIcon
                class="mr-0.5 !align-middle"
                :icon="faCircleCheck"
                size="sm"
                fixed-width
            />

            {{ message }}
        </span>
    </Transition>
</template>
