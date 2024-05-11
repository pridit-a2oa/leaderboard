<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faCog,
    faUser,
    faPlug,
    faBars,
    faBan,
} from '@fortawesome/free-solid-svg-icons';
import Breadcrumb from '@/Components/Breadcrumb.vue';

defineProps({ title: String });

const settings = ref([
    { type: 'account', icon: faCog },
    { type: 'characters', icon: faUser },
    { type: 'connections', icon: faPlug },
    { type: 'features', icon: faBars },
]);
</script>

<template>
    <div class="flex w-full">
        <div class="font-semibold">
            <ul class="menu w-44 rounded-md bg-base-200">
                <li
                    v-for="setting in settings"
                    class="capitalize [&:not(:last-child)]:mb-1"
                >
                    <Link
                        class="pl-2"
                        :class="{
                            active: $page.component
                                .toLowerCase()
                                .includes(setting.type),
                        }"
                        :href="`/settings/${setting.type}`"
                        ><font-awesome-icon
                            :icon="setting.icon"
                            fixed-width
                        />{{ setting.type }}</Link
                    >
                </li>
            </ul>

            <ul class="menu mt-4 w-44 rounded-md bg-base-200">
                <li>
                    <Link
                        class="pl-2 !text-red-500"
                        :class="{
                            active: $page.component.includes('Delete'),
                        }"
                        href="/settings/delete"
                        ><font-awesome-icon :icon="faBan" fixed-width />Delete
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
    @apply mb-6 text-xl font-semibold;
}

a.active {
    @apply !bg-[#333333];
}
</style>
