<script setup>
import { AdminMenu } from '@/Components/features/cms';
import { SuffixText } from '@/Components/text';
import {
    faCircle,
    faCircleUser,
    faPersonRifle,
    faPlug,
    faStar,
    faTriangleExclamation,
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
    { type: 'characters', icon: faPersonRifle, disabled: false },
    { type: 'connections', icon: faPlug, disabled: false },
    { type: 'extras', icon: faStar, disabled: false },
]);
</script>

<template>
    <div class="flex">
        <div>
            <div
                v-if="$page.props.auth.role.name === 'admin'"
                role="tablist"
                class="tabs-box tabs mb-4 flex-nowrap gap-x-1"
            >
                <a
                    v-for="(category, index) in ['user', 'admin']"
                    role="tab"
                    class="tab hover:!bg-highlight h-8 basis-1/2 capitalize"
                    :class="[
                        tab.value === category
                            ? '!bg-highlight tab-active'
                            : '',
                        index === 0 ? '!rounded-e-none' : '!rounded-s-none',
                    ]"
                    @click="tab = category"
                    >{{ category }}</a
                >
            </div>

            <template v-if="tab.value === 'user'">
                <ul class="menu bg-base-200 w-44 gap-1 rounded-lg">
                    <li
                        v-for="setting in settings"
                        class="group/parent capitalize"
                        :class="{
                            'menu-disabled opacity-60 [&>a>div>svg]:opacity-40':
                                setting.disabled,
                        }"
                    >
                        <Link
                            class="group/link hover:bg-highlight px-2 group-[.menu-disabled]/parent:cursor-not-allowed"
                            :class="{
                                '!bg-highlight': $page.component
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
                            <FontAwesomeLayers class="indicator">
                                <FontAwesomeIcon
                                    class="text-neutral-400"
                                    :icon="setting.icon"
                                />
                                <FontAwesomeIcon
                                    v-if="setting.type === 'connections'"
                                    class="indicator-item indicator-end indicator-bottom bg-base-200 group-hover/link:bg-highlight rounded-full transition delay-[0ms]"
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
                                    transform="shrink-6 left-2"
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

                <ul class="menu bg-base-200 mt-4 w-44 rounded-md">
                    <li>
                        <Link
                            class="!text-error hover:bg-highlight pl-2"
                            :class="{
                                'bg-highlight':
                                    $page.component.includes('Delete'),
                            }"
                            :href="route('user.setting.delete')"
                        >
                            <FontAwesomeIcon :icon="faTriangleExclamation" />
                            Delete Account
                        </Link>
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
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
}
</style>
