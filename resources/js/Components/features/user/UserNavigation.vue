<script setup>
import { UserRoleIcon } from '@/Components/features/user';
import {
    faBars,
    faCaretDown,
    faRightFromBracket,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div class="indicator ml-auto hidden md:inline-flex">
        <UserRoleIcon />

        <div class="dropdown dropdown-bottom">
            <button class="btn" tabindex="0">
                Account
                <FontAwesomeIcon class="text-neutral-600" :icon="faCaretDown" />
            </button>

            <ul
                class="menu dropdown-content bg-base-200 z-10 mt-1 w-32 rounded-md p-2 shadow"
                tabindex="0"
            >
                <li class="mb-0.5">
                    <Link class="pl-2" :href="route('user.setting.account')">
                        <FontAwesomeIcon :icon="faBars" fixed-width />
                        Settings
                    </Link>
                </li>

                <li>
                    <Link
                        class="text-error focus:text-error active:!text-error pl-2"
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        <FontAwesomeIcon
                            :icon="faRightFromBracket"
                            fixed-width
                        />
                        Sign out
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>
