<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faBullhorn,
    faHeart,
    faUser,
    faCog,
    faRightToBracket,
    faRightFromBracket,
    faArrowRightLong,
} from '@fortawesome/free-solid-svg-icons';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { LoginForm, RegistrationForm } from '@/Components/Form';
import ExtLink from '@/Components/ExtLink.vue';
import Modal from '@/Components/Modal.vue';

const showModal = ref(false);

const register = ref(false);
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
            <div
                tabindex="0"
                role="button"
                class="btn no-animation"
                :title="$page.props.auth.user.name"
            >
                <FontAwesomeIcon :icon="faUser" size="sm" />
                <span class="max-w-16 truncate">
                    {{ $page.props.auth.user.name }}
                </span>
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

        <template v-else>
            <button
                class="btn no-animation ml-auto hidden md:inline-flex"
                @click="showModal = true"
            >
                <FontAwesomeIcon :icon="faRightToBracket" size="sm" />Log in
            </button>

            <Modal
                :class="{ 'modal-open': showModal }"
                @close="showModal = false"
            >
                <LoginForm v-if="!register" title="Sign in">
                    <div class="pt-4 text-center text-sm">
                        <span>Not registered?&nbsp;</span>

                        <button
                            class="underlined-link"
                            @click="register = true"
                        >
                            Sign up

                            <FontAwesomeIcon
                                class="ml-0.5 !align-middle"
                                :icon="faArrowRightLong"
                                size="xs"
                            />
                        </button>
                    </div>
                </LoginForm>

                <RegistrationForm v-else title="Register account">
                    <div class="pt-4 text-center text-sm">
                        <span>Already registered?&nbsp;</span>

                        <button
                            class="underlined-link"
                            @click="register = false"
                        >
                            Log in

                            <FontAwesomeIcon
                                class="ml-0.5 !align-middle"
                                :icon="faArrowRightLong"
                                size="xs"
                            />
                        </button>
                    </div>
                </RegistrationForm>
            </Modal>
        </template>
    </div>
</template>
