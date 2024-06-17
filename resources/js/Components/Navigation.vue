<script setup>
import ExtLink from '@/Components/ExtLink.vue';
import SupporterBadge from '@/Components/SupporterBadge.vue';
import {
    faBullhorn,
    faHeart,
    faCog,
    faRightToBracket,
    faRightFromBracket,
    faCaretDown,
} from '@fortawesome/free-solid-svg-icons';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
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
            class="text-supporter"
            href="https://ko-fi.com/pridit"
            :icon="faHeart"
            >Ko-fi</ExtLink
        >

        <div
            v-if="$page.props.auth.user"
            class="indicator ml-auto hidden md:inline-flex"
        >
            <SupporterBadge />

            <div class="dropdown dropdown-bottom">
                <button tabindex="0" class="btn">
                    <span class="max-w-16 truncate">Account</span>

                    <FontAwesomeIcon
                        class="text-neutral-600"
                        :icon="faCaretDown"
                    />
                </button>

                <ul
                    tabindex="0"
                    class="menu dropdown-content z-[1] mt-1 w-32 rounded-md bg-base-200 p-2 shadow"
                >
                    <li>
                        <Link class="px-2" :href="route('user.setting.account')"
                            ><FontAwesomeIcon :icon="faCog" />Settings
                        </Link>
                    </li>

                    <li>
                        <Link
                            class="px-2"
                            :href="route('logout')"
                            method="post"
                            as="button"
                            ><FontAwesomeIcon :icon="faRightFromBracket" />Log
                            out</Link
                        >
                    </li>
                </ul>
            </div>
        </div>

        <template v-else>
            <label
                for="modal"
                class="btn no-animation ml-auto hidden md:inline-flex"
                role="button"
                tabindex="0"
                dusk="login-button"
            >
                <FontAwesomeIcon :icon="faRightToBracket" size="sm" />Sign in
            </label>
        </template>
    </div>
</template>
