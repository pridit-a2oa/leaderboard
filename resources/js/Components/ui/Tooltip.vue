<script setup>
import { faCamera } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

defineProps({
    path: {
        type: String,
        required: true,
    },

    alt: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="dropdown-hover dropdown" role="link" tabindex="0">
        <span class="underlined-rich">
            <slot />
            <FontAwesomeIcon
                class="mx-1 opacity-60"
                :icon="faCamera"
                transform="down-1"
            />
        </span>

        <div>
            <picture
                class="dropdown-content top-10 left-2/4 z-20 w-54 -translate-x-2/4 scale-x-[-1] rounded-lg bg-base-300 p-2 px-4 drop-shadow-lg"
            >
                <source type="image/webp" :srcset="`${path}.webp`" />
                <img :src="`${path}.png`" :alt="alt" loading="lazy" />
            </picture>
        </div>
    </div>
</template>
