<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    meta: {
        type: Array,
    },
});
</script>

<template>
    <div v-if="meta.links.length > 3" class="join mt-4 flex">
        <template v-for="(link, key) in meta.links" :key="key">
            <Link
                class="btn first:mr-auto last:ml-auto"
                :class="{
                    '!hidden': link.label === '...' || !!/\d/.test(link.label),
                    'btn-disabled invisible': link.url === null,
                    'bg-neutral-700 hover:bg-neutral-700': link.active,
                    '!text-neutral-600':
                        parseInt(link.label) > meta.current_page + 1 ||
                        parseInt(link.label) < meta.current_page - 1,
                }"
                :style="{ order: key }"
                :href="link.url ?? '#'"
                preserve-scroll
                ><span v-html="link.label"></span
            ></Link>
        </template>

        <span
            class="order-1 hidden flex-1 self-center text-center text-sm md:block"
            >Showing <strong>{{ meta.from }}</strong> &dash;
            <strong>{{ meta.to }}</strong> of
            <strong>{{ meta.total }}</strong> records</span
        >
    </div>
</template>
