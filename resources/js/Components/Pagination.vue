<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
    },
    currentPage: {
        type: Number,
    },
});
</script>

<template>
    <div v-if="links.length > 3" class="join mb-8 flex justify-center">
        <template v-for="(link, key) in links">
            <Link
                class="btn no-animation first:mr-auto last:ml-auto [&:not(:first-child):not(:last-child)]:hidden md:[&:not(:first-child):not(:last-child)]:inline-flex"
                :class="{
                    '!hidden': link.label === '...',
                    'btn-disabled invisible': link.url === null,
                    'bg-neutral-700 hover:bg-neutral-700': link.active,
                    'join-item': !!/\d/.test(link.label),
                    '!text-neutral-600':
                        parseInt(link.label) > currentPage + 1 ||
                        parseInt(link.label) < currentPage - 1,
                }"
                :href="link.url"
                v-html="link.label"
                preserve-scroll
            />
        </template>
    </div>
</template>
