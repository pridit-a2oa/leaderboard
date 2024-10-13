<script setup>
import { AdminMenu } from '@/Components/features/cms';
import {
    faCircle,
    faCircleUser,
    faLock,
    faPlug,
    faStar,
    faTrashCan,
    faUser,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    title: {
        type: String,
    },
});

const verifiedEmail = computed(() => {
    return usePage().props.auth.user.email_verified_at !== null;
});

const settings = ref([
    { type: 'account', icon: faCircleUser },
    { type: 'characters', icon: faUser },
    { type: 'connections', icon: faPlug },
    { type: 'extras', icon: faStar },
]);
</script>

<template>
    <div class="flex w-full">
        <div>
            <ul class="menu w-44 rounded-md bg-base-200">
                <li
                    v-for="setting in settings"
                    class="capitalize [&:not(:last-child)]:mb-1"
                    :class="{
                        'disabled opacity-40':
                            ['characters', 'connections'].includes(
                                setting.type,
                            ) && !verifiedEmail,
                    }"
                >
                    <Link
                        class="group px-2 hover:focus:active:!bg-highlight"
                        :class="{
                            'bg-highlight': $page.component
                                .toLowerCase()
                                .includes(setting.type),
                        }"
                        :href="
                            ['characters', 'connections'].includes(
                                setting.type,
                            ) && !verifiedEmail
                                ? '#'
                                : route(`user.setting.${setting.type}`)
                        "
                    >
                        <FontAwesomeLayers class="indicator" fixed-width>
                            <FontAwesomeIcon
                                class="text-neutral-400"
                                :icon="setting.icon"
                            />
                            <FontAwesomeIcon
                                v-if="
                                    setting.type === 'connections' &&
                                    verifiedEmail
                                "
                                class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 transition delay-[0ms] group-hover:bg-highlight"
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

                        {{ setting.type }}

                        <FontAwesomeIcon
                            v-if="
                                ['characters', 'connections'].includes(
                                    setting.type,
                                ) && !verifiedEmail
                            "
                            :icon="faLock"
                            size="sm"
                            title="Please verify your email"
                            fixed-width
                        />
                    </Link>
                </li>
            </ul>

            <ul class="menu mt-4 w-44 rounded-md bg-base-200">
                <li>
                    <Link
                        class="pl-2 !text-error hover:focus:active:bg-highlight"
                        :class="{
                            'bg-highlight': $page.component.includes('Delete'),
                        }"
                        :href="route('user.setting.delete')"
                        ><FontAwesomeIcon
                            :icon="faTrashCan"
                            fixed-width
                        />Delete Account</Link
                    >
                </li>
            </ul>

            <AdminMenu />
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

<style scoped>
h2 {
    @apply text-xl font-semibold;
}
</style>
