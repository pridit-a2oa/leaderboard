<script setup>
import { SuffixText } from '@/Components/text';
import {
    faChartLine,
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
    { type: 'dashboard', icon: faChartLine },
    { type: 'mutes', icon: faCommentSlash },
    { type: 'users', icon: faUsers },
    { type: 'webhooks', icon: faCircleNodes },
]);
</script>

<template>
    <ul
        v-if="$page.props.auth.role.name === 'admin'"
        class="menu mt-4 w-44 gap-1 rounded-md bg-base-200"
    >
        <li v-for="setting in settings" class="capitalize">
            <Link
                class="group px-2 hover:bg-highlight"
                :class="{
                    'bg-highlight': $page.component
                        .toLowerCase()
                        .includes(setting.type),
                }"
                :href="route(`user.setting.${setting.type}.index`)"
            >
                <FontAwesomeLayers class="indicator">
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
