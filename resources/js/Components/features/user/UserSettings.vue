<script setup>
import { AdminMenu } from '@/Components/features/cms';
import { SuffixText } from '@/Components/text';
import {
    faCircle,
    faCircleUser,
    faPlug,
    faStar,
    faTrashCan,
    faUser,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    title: {
        type: String,
    },
});

const category = ref(usePage().props.category);

const tab = computed({
    get() {
        return category;
    },

    set(value) {
        category.value = value;
    },
});

const settings = ref([
    { type: 'account', icon: faCircleUser, disabled: false },
    { type: 'characters', icon: faUser, disabled: false },
    { type: 'connections', icon: faPlug, disabled: false },
    { type: 'extras', icon: faStar, disabled: false },
]);
</script>

<template>
    <div class="flex w-full">
        <div>
            <div
                v-if="$page.props.auth.role === 'admin'"
                role="tablist"
                class="tabs-boxed tabs mb-4 gap-x-1"
            >
                <a
                    v-for="(category, index) in ['user', 'admin']"
                    role="tab"
                    class="tab capitalize hover:!bg-highlight"
                    :class="[
                        tab.value === category ? 'bg-highlight' : '',
                        index === 0 ? '!rounded-e-sm' : '!rounded-s-sm',
                    ]"
                    @click="tab = category"
                    >{{ category }}</a
                >
            </div>

            <template v-if="tab.value === 'user'">
                <ul class="menu w-44 rounded-md bg-base-200">
                    <li
                        v-for="setting in settings"
                        class="group/parent capitalize [&:not(:last-child)]:mb-1"
                        :class="{
                            'disabled opacity-60 [&>a>div>svg]:opacity-40':
                                setting.disabled,
                        }"
                    >
                        <Link
                            class="group/link px-2 hover:focus:active:!bg-highlight group-[.disabled]/parent:cursor-not-allowed"
                            :class="{
                                'bg-highlight': $page.component
                                    .toLowerCase()
                                    .includes(setting.type),
                            }"
                            :href="
                                setting.disabled
                                    ? '#'
                                    : route(`user.setting.${setting.type}`)
                            "
                            :title="
                                (setting.disabled &&
                                    'Please verify your email') ||
                                ''
                            "
                        >
                            <FontAwesomeLayers class="indicator" fixed-width>
                                <FontAwesomeIcon
                                    class="text-neutral-400"
                                    :icon="setting.icon"
                                />
                                <FontAwesomeIcon
                                    v-if="setting.type === 'connections'"
                                    class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 transition delay-[0ms] group-hover/link:bg-highlight"
                                    :class="{
                                        'bg-highlight': $page.component
                                            .toLowerCase()
                                            .includes(setting.type),
                                        'text-error':
                                            $page.props.auth.user.connections
                                                .length === 0,
                                        'text-success':
                                            $page.props.auth.user.connections
                                                .length > 0,
                                    }"
                                    :icon="faCircle"
                                    size="xs"
                                    transform="shrink-6"
                                />
                            </FontAwesomeLayers>

                            <span class="truncate">
                                {{ setting.type }}
                            </span>

                            <SuffixText
                                :value="$page.props.model_counts[setting.type]"
                            />
                        </Link>
                    </li>
                </ul>

                <ul class="menu mt-4 w-44 rounded-md bg-base-200">
                    <li>
                        <Link
                            class="pl-2 !text-error hover:focus:active:bg-highlight"
                            :class="{
                                'bg-highlight':
                                    $page.component.includes('Delete'),
                            }"
                            :href="route('user.setting.delete')"
                            ><FontAwesomeIcon
                                :icon="faTrashCan"
                                fixed-width
                            />Delete Account</Link
                        >
                    </li>
                </ul>
            </template>

            <AdminMenu v-if="tab.value === 'admin'" />
        </div>

        <div class="ml-4 w-full text-neutral-300">
            <div class="mb-4 flex items-center">
                <h2 class="grow">{{ title }}</h2>

                <slot name="header"></slot>
            </div>

            <slot />
        </div>
    </div>
</template>

<style>
h2 {
    @apply text-xl font-semibold;
}
</style>
