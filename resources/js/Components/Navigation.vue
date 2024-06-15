<script setup>
import { ref } from 'vue';
import { LoginForm, RegistrationForm } from '@/Components/Form';
import ExtLink from '@/Components/ExtLink.vue';
import Modal from '@/Components/Modal.vue';
import SupporterBadge from '@/Components/SupporterBadge.vue';
import {
    faBullhorn,
    faHeart,
    faUser,
    faCog,
    faRightToBracket,
    faRightFromBracket,
    faCaretDown,
    faArrowRightLong,
} from '@fortawesome/free-solid-svg-icons';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';

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
            class="text-supporter"
            href="https://ko-fi.com/pridit"
            :icon="faHeart"
            >Ko-fi</ExtLink
        >

        <div
            v-if="$page.props.auth.user"
            class="dropdown dropdown-bottom indicator ml-auto hidden md:inline-flex"
        >
            <SupporterBadge />

            <button tabindex="0" class="btn">
                <span class="max-w-16 truncate">Account</span>

                <FontAwesomeIcon class="text-neutral-600" :icon="faCaretDown" />
            </button>

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
                @click="
                    showModal = true;
                    register = false;
                "
            >
                <FontAwesomeIcon :icon="faRightToBracket" size="sm" />Sign in
            </button>

            <Modal
                :class="{ 'modal-open': showModal }"
                @close="showModal = false"
            >
                <LoginForm v-if="!register" title="Sign in">
                    <div class="pt-4 text-center text-sm">
                        <span>No account?&nbsp;</span>

                        <button
                            class="underlined-link"
                            @click="register = true"
                        >
                            Sign up<FontAwesomeIcon
                                class="ml-1 !align-middle"
                                :icon="faArrowRightLong"
                                size="xs"
                            />
                        </button>
                    </div>
                </LoginForm>

                <RegistrationForm v-else title="Sign up">
                    <div class="pt-4 text-center text-sm">
                        <span>Already registered?&nbsp;</span>

                        <button
                            class="underlined-link"
                            @click="register = false"
                        >
                            Sign in<FontAwesomeIcon
                                class="ml-1 !align-middle"
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
