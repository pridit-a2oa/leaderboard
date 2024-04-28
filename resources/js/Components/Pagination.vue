<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
  }
}
</script>

<template>
    <div v-if="links.length > 3" class="flex justify-center">
        <div class="join pb-10">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null"
                    :key="key"
                    class="join-item btn disabled"
                    v-html="link.label"
                />

                <Link v-else class="join-item btn"
                    :class="{ 'bg-zinc-700': link.active }"
                    :href="link.url"
                    v-html="link.label"
                    preserve-scroll
                />
            </template>
        </div>
    </div>
</template>
