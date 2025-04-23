<script setup>
import {
    faCircleCheck,
    faCircleExclamation,
    faCircleXmark,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    message: {
        type: Array,
        default: [],
    },
});

function messageType(type) {
    switch (type) {
        case 'error':
            return ['text-error', faCircleXmark];
        case 'success':
            return ['text-success', faCircleCheck];
        case 'warning':
            return ['text-warning', faCircleExclamation];
    }
}
</script>

<template v-if="message.length > 0">
    <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
    >
        <span
            class="flex-1 self-center text-xs select-none"
            :class="messageType(message[0])[0]"
        >
            <FontAwesomeIcon
                size="lg"
                :icon="messageType(message[0])[1]"
                fixed-width
            />

            <span class="ml-1 font-semibold">
                {{ message[1] }}
            </span>
        </span>
    </Transition>
</template>
