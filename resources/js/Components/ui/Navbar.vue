<script setup>
import { UserSupporterIcon } from '@/Components/features/user';
import { ButtonLink } from '@/Components/links';
import {
    faBullhorn,
    faHeart,
    faBars,
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
        <ButtonLink href="https://dsc.gg/pridit">
            <FontAwesomeIcon
                class="text-[#7289da]"
                :icon="faDiscord"
                size="sm"
            />

            Discord
        </ButtonLink>

        <ButtonLink href="https://feedback.pridit.co.uk">
            <FontAwesomeIcon
                class="text-yellow-600"
                :icon="faBullhorn"
                size="sm"
            />

            Feedback
        </ButtonLink>

        <ButtonLink href="https://ko-fi.com/pridit">
            <FontAwesomeIcon class="text-supporter" :icon="faHeart" size="sm" />

            Ko-fi
        </ButtonLink>

        <div
            v-if="$page.props.auth.user"
            class="indicator ml-auto hidden md:inline-flex"
        >
            <UserSupporterIcon />

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
                    class="menu dropdown-content z-10 mt-1 w-32 rounded-md bg-base-200 p-2 shadow"
                >
                    <li class="mb-0.5">
                        <Link class="pl-2" :href="route('user.setting.account')"
                            ><FontAwesomeIcon
                                :icon="faBars"
                                fixed-width
                            />Settings
                        </Link>
                    </li>

                    <li>
                        <Link
                            class="pl-2 text-error focus:text-error active:!text-error"
                            :href="route('logout')"
                            method="post"
                            as="button"
                            ><FontAwesomeIcon
                                :icon="faRightFromBracket"
                                fixed-width
                            />Sign out</Link
                        >
                    </li>
                </ul>
            </div>
        </div>

        <template v-else>
            <label
                for="account-modal"
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
