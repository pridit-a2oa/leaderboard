<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
};
</script>

<template>
    <div v-if="links.length > 3" class="join mb-8 flex justify-center">
        <template v-for="(link, key) in links">
            <Link
                class="btn no-animation first:mr-auto last:ml-auto"
                :class="{
                    hidden: link.label === '...',
                    'btn-disabled invisible': link.url === null,
                    'bg-neutral-700 hover:bg-neutral-700': link.active,
                    'join-item': !!/\d/.test(link.label),
                }"
                :href="link.url"
                v-html="link.label"
                preserve-scroll
            />
        </template>
    </div>
</template>
