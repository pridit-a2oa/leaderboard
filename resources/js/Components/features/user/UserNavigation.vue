<script setup>
import { UserRoleIcon } from '@/Components/features/user';
import {
    faBars,
    faCaretDown,
    faRightFromBracket,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
    filter: usePage().props.filter ?? undefined,
});
</script>

<template>
    <div
        class="indicator hidden w-full gap-x-3 text-right md:inline-grid md:grid-cols-[1fr_1fr]"
    >
        <form
            v-if="$page.props.auth.user !== null"
            @change="form.get(route('home'))"
        >
            <select
                class="select select-sm bg-base-300 h-full"
                :class="{
                    '!cursor-not-allowed': !$page.props.characters.meta,
                }"
                v-model="form.filter"
                :disabled="!$page.props.characters.meta"
            >
                <option :value="undefined">(All)</option>
                <option value="active">Active</option>
                <option value="me">Me</option>
            </select>
        </form>

        <div
            :class="{
                'col-start-2': $page.props.auth.role.name !== 'admin',
            }"
        >
            <UserRoleIcon />

            <div class="dropdown dropdown-bottom">
                <div
                    class="btn"
                    role="button"
                    tabindex="0"
                    dusk="account-button"
                >
                    Account
                    <FontAwesomeIcon
                        class="text-neutral-600"
                        :icon="faCaretDown"
                        size="sm"
                    />
                </div>

                <ul
                    class="menu dropdown-content bg-base-200 z-10 mt-1 w-32 gap-1 rounded-md p-2 shadow"
                >
                    <li>
                        <Link
                            class="hover:bg-highlight pl-2"
                            :href="route('user.setting.account')"
                        >
                            <FontAwesomeIcon :icon="faBars" />
                            Settings
                        </Link>
                    </li>

                    <li>
                        <Link
                            class="text-error hover:bg-highlight pl-2 focus:cursor-pointer"
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            <FontAwesomeIcon :icon="faRightFromBracket" />
                            Sign out
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
