<script setup>
import { Link } from '@inertiajs/vue3';
import ExtLink from '@/Components/ExtLink.vue';
import Login from '@/Components/Modal/Login.vue';
</script>

<template>
    <div class="mt-8 flex flex-col justify-between gap-3 xs:flex-row">
        <ExtLink
            class="text-[#7289da]"
            href="https://dsc.gg/pridit"
            :icon="['brands', 'discord']"
            >Discord</ExtLink
        >

        <ExtLink
            class="text-yellow-600"
            href="https://feedback.pridit.co.uk"
            :icon="['fas', 'bullhorn']"
            >Feedback</ExtLink
        >

        <ExtLink
            class="text-[#ff5c5a]"
            href="https://ko-fi.com/pridit"
            :icon="['fas', 'heart']"
            >Ko-fi</ExtLink
        >

        <div
            v-if="$page.props.auth.user"
            class="dropdown dropdown-bottom ml-auto hidden md:inline-flex"
        >
            <div tabindex="0" role="button" class="btn no-animation">
                <font-awesome-icon :icon="['fas', 'user']" size="sm" />
                {{ $page.props.auth.user.name }}
            </div>
            <ul
                tabindex="0"
                class="menu dropdown-content z-[1] mt-1 w-32 rounded-box bg-base-200 p-2 shadow"
            >
                <li>
                    <Link href="/settings/account"
                        ><font-awesome-icon :icon="['fas', 'cog']" />Settings
                    </Link>
                </li>
                <li>
                    <Link :href="route('logout')" method="post" as="button"
                        ><font-awesome-icon
                            :icon="['fas', 'right-from-bracket']"
                        />Log out</Link
                    >
                </li>
            </ul>
        </div>

        <Login v-else />
    </div>
</template>
