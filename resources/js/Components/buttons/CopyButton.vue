<script setup>
import {
    faClipboard,
    faClipboardCheck,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { ref } from 'vue';
import { copyText } from 'vue3-clipboard';

const toggled = ref(false);

const props = defineProps({
    value: {
        type: String,
        required: true,
    },
});

const copy = () => {
    copyText(props.value, undefined, (error) => {
        if (!error) {
            toggled.value = true;
            setTimeout(() => (toggled.value = false), 1500);
        }
    });
};
</script>

<template>
    <FontAwesomeIcon
        v-if="
            $page.props.auth.user !== null &&
            $page.props.auth.role.name === 'admin'
        "
        class="ml-2 !align-middle text-neutral-600 hover:text-neutral-400"
        :class="{
            'cursor-pointer': !toggled,
        }"
        :icon="toggled ? faClipboardCheck : faClipboard"
        size="lg"
        title="Copy ID64"
        v-on="!toggled ? { click: copy } : {}"
    />
</template>
