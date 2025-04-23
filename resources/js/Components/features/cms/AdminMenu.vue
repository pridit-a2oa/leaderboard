<script setup>
import { SuffixText } from '@/Components/text';
import {
    faCircleNodes,
    faCommentSlash,
    faUsers,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
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
        class="menu bg-base-200 mt-4 w-44 rounded-md"
    >
        <li
            v-for="setting in settings"
            class="capitalize [&:not(:last-child)]:mb-1"
        >
            <Link
                class="group hover:focus:active:!bg-highlight px-2"
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
                </FontAwesomeLayers>

                <span class="truncate">
                    {{ setting.type }}
                </span>

                <SuffixText :value="$page.props.model_counts[setting.type]" />
            </Link>
        </li>
    </ul>
</template>

<style scoped>
h2 {
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
}
</style>
