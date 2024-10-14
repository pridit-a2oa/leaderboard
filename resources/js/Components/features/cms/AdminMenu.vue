<script setup>
import {
    faCircleNodes,
    faCommentSlash,
    faUsers,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    title: {
        type: String,
    },
});

const settings = ref([
    { type: 'mutes', icon: faCommentSlash },
    { type: 'users', icon: faUsers },
    { type: 'webhooks', icon: faCircleNodes },
]);
</script>

<template>
    <ul
        v-if="$page.props.auth.role === 'admin'"
        class="menu mt-4 w-44 rounded-md border-r-4 border-error/75 bg-base-200"
    >
        <li
            v-for="setting in settings"
            class="capitalize [&:not(:last-child)]:mb-1"
        >
            <Link
                class="group px-2 hover:focus:active:!bg-highlight"
                :class="{
                    'bg-highlight': $page.component
                        .toLowerCase()
                        .includes(setting.type),
                }"
                :href="route(`user.setting.${setting.type}.index`)"
            >
                <FontAwesomeLayers class="indicator" fixed-width>
                    <FontAwesomeIcon
                        class="text-neutral-400"
                        :icon="setting.icon"
                    />
                    <FontAwesomeIcon
                        v-if="setting.type === 'connections' && verifiedEmail"
                        class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 transition delay-[0ms] group-hover:bg-highlight"
                        :class="{
                            'bg-highlight': $page.component
                                .toLowerCase()
                                .includes(setting.type),
                            'text-error':
                                $page.props.auth.user.connections.length === 0,
                            'text-success':
                                $page.props.auth.user.connections.length > 0,
                        }"
                        :icon="faCircle"
                        size="xs"
                        transform="shrink-6"
                    />
                </FontAwesomeLayers>

                <span class="truncate">
                    {{ setting.type }}
                </span>

                <span
                    v-if="$page.props.auth.model_counts[setting.type] !== '0'"
                    class="outline-solid rounded-full bg-base-300 px-1.5 text-xs outline outline-1 outline-offset-1 outline-neutral-500"
                    >{{ $page.props.auth.model_counts[setting.type] }}</span
                >
            </Link>
        </li>
    </ul>
</template>

<style scoped>
h2 {
    @apply text-xl font-semibold;
}
</style>
