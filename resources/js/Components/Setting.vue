<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faCog,
    faUser,
    faPlug,
    faStar,
    faBan,
    faLock,
} from '@fortawesome/free-solid-svg-icons';

defineProps({ title: String });

const settings = ref([
    { type: 'account', icon: faCog },
    { type: 'characters', icon: faUser },
    { type: 'connections', icon: faPlug },
    { type: 'extras', icon: faStar },
]);
</script>

<template>
    <div class="flex w-full">
        <div class="font-semibold">
            <ul class="menu w-44 rounded-md bg-base-200">
                <li
                    v-for="setting in settings"
                    class="capitalize [&:not(:last-child)]:mb-1"
                    :class="{
                        'disabled opacity-40':
                            ['characters', 'connections'].includes(
                                setting.type,
                            ) &&
                            $page.props.auth.user.email_verified_at === null,
                    }"
                >
                    <Link
                        class="px-2 !text-neutral-400"
                        :class="{
                            active: $page.component
                                .toLowerCase()
                                .includes(setting.type),
                        }"
                        :href="
                            ['characters', 'connections'].includes(
                                setting.type,
                            ) &&
                            $page.props.auth.user.email_verified_at === null
                                ? '#'
                                : route(`user.setting.${setting.type}`)
                        "
                        ><FontAwesomeIcon :icon="setting.icon" fixed-width />{{
                            setting.type
                        }}

                        <FontAwesomeIcon
                            v-if="
                                ['characters', 'connections'].includes(
                                    setting.type,
                                ) &&
                                $page.props.auth.user.email_verified_at === null
                            "
                            :icon="faLock"
                            size="sm"
                            title="Verified email required"
                            fixed-width
                        />
                    </Link>
                </li>
            </ul>

            <ul class="menu mt-4 w-44 rounded-md bg-base-200">
                <li>
                    <Link
                        class="pl-2 !text-red-500"
                        :class="{
                            active: $page.component.includes('Delete'),
                        }"
                        :href="route('user.setting.delete')"
                        ><FontAwesomeIcon :icon="faBan" fixed-width />Delete
                        Account</Link
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

a.active {
    @apply !bg-[#333333];
}
</style>
