<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    icon: {
        type: String,
    },
});
</script>

<template>
    <div
        v-if="$page.component !== 'Home'"
        class="flex flex bg-base-300 text-sm"
    >
        <div class="container breadcrumbs mx-auto py-4">
            <ul>
                <li>
                    <Link class="underlined-link" :href="route('home')">
                        <font-awesome-icon
                            class="mr-2"
                            :icon="['fas', 'house']"
                            size="sm"
                            fixed-width
                        />
                        Home
                    </Link>
                </li>
                <li class="text-neutral-300">
                    <font-awesome-icon
                        class="mr-2"
                        :icon="['fas', $page.props.icon]"
                        size="sm"
                        fixed-width
                    />
                    {{ $page.props.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
