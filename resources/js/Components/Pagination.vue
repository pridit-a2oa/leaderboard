<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
    },
    currentPage: {
        type: Number,
    },
    from: {
        type: Number,
    },
    to: {
        type: Number,
    },
    total: {
        type: Number,
    },
});
</script>

<template v-if="links.length > 3">
    <template v-if="links.length > 3">
        <div class="join mb-8 mt-4 flex">
            <template v-for="(link, key) in links">
                <Link
                    class="btn no-animation first:mr-auto last:ml-auto [&:not(:first-child):not(:last-child)]:hidden md:[&:not(:first-child):not(:last-child)]:inline-flex"
                    :class="{
                        '!hidden':
                            link.label === '...' || !!/\d/.test(link.label),
                        'btn-disabled invisible': link.url === null,
                        'bg-neutral-700 hover:bg-neutral-700': link.active,
                        '!text-neutral-600':
                            parseInt(link.label) > currentPage + 1 ||
                            parseInt(link.label) < currentPage - 1,
                    }"
                    :style="{ order: key }"
                    :href="link.url"
                    v-html="link.label"
                    preserve-scroll
                />
            </template>

            <span class="order-1 flex-1 self-center text-center text-sm"
                >Showing <strong>{{ from }}</strong> &dash;
                <strong>{{ to }}</strong> of
                <strong>{{ total }}</strong> records</span
            >
        </div>
    </template>
</template>
