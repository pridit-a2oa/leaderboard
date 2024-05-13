<script setup>
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faBullhorn,
    faHeart,
    faUser,
    faCog,
    faRightFromBracket,
} from '@fortawesome/free-solid-svg-icons';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import ExtLink from '@/Components/ExtLink.vue';
import Login from '@/Components/Modal/Login.vue';
</script>

<template>
    <div class="flex flex-col justify-between gap-3 xs:flex-row">
        <ExtLink
            class="text-[#7289da]"
            href="https://dsc.gg/pridit"
            :icon="faDiscord"
            >Discord</ExtLink
        >

        <ExtLink
            class="text-yellow-600"
            href="https://feedback.pridit.co.uk"
            :icon="faBullhorn"
            >Feedback</ExtLink
        >

        <ExtLink
            class="text-[#ff5c5a]"
            href="https://ko-fi.com/pridit"
            :icon="faHeart"
            >Ko-fi</ExtLink
        >

        <div
            v-if="$page.props.auth.user"
            class="dropdown dropdown-bottom ml-auto hidden md:inline-flex"
        >
            <div tabindex="0" role="button" class="btn no-animation">
                <FontAwesomeIcon :icon="faUser" size="sm" />
                {{ $page.props.auth.user.name }}
            </div>
            <ul
                tabindex="0"
                class="menu dropdown-content z-[1] mt-1 w-32 rounded-md bg-base-200 p-2 shadow"
            >
                <li>
                    <Link :href="route('user.setting.account')"
                        ><FontAwesomeIcon :icon="faCog" />Settings
                    </Link>
                </li>
                <li>
                    <Link :href="route('logout')" method="post" as="button"
                        ><FontAwesomeIcon :icon="faRightFromBracket" />Log
                        out</Link
                    >
                </li>
            </ul>
        </div>

        <Login v-else />
    </div>
</template>
