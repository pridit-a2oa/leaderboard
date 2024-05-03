<script setup>
const props = defineProps({
    class: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <a :href="href" class="btn no-animation" target="_blank">
        <font-awesome-icon :icon="icon" :class="class" size="sm" />
        <slot />
        <font-awesome-icon
            :icon="['fas', 'arrow-up-right-from-square']"
            size="xs"
        />
    </a>
</template>
