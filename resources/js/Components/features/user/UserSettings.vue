<script setup>
import { computed, ref } from 'vue';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
import {
    faCircle,
    faCircleUser,
    faLock,
    faPlug,
    faStar,
    faTrashCan,
    faUser,
} from '@fortawesome/free-solid-svg-icons';
import { Link, usePage } from '@inertiajs/vue3';

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
                        class="hover:focus:active:!bg-highlight group px-2"
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
                                class="group-hover:bg-highlight indicator-item indicator-end indicator-bottom rounded-full bg-base-200 transition delay-[0ms]"
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
                        class="hover:focus:active:bg-highlight pl-2 !text-error"
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
        </div>

        <div class="ml-6 w-full text-neutral-300">
            <h2>{{ title }}</h2>
            <slot />
        </div>
    </div>
</template>

<style scoped>
h2 {
    @apply mb-4 text-xl font-semibold;
}
</style>
