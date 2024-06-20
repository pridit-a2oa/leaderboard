<script setup>
import { LinkButton } from '@/Components/features/character';
import { RewardIcon } from '@/Components/features/reward';
import { NormalLink } from '@/Components/links';
import {
    faArrowRightLong,
    faPlug,
    faGun,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div class="alert mb-6 hidden rounded-lg md:grid" role="alert">
        <RewardIcon :user="$page.props.auth.user" />

        <div class="text-sm">
            <div class="dropdown dropdown-hover">
                <span class="tooltip-benefit">Link</span>

                <div class="dropdown-content z-20 w-max">
                    <ol
                        class="mt-2 flex list-inside list-decimal flex-col gap-4 rounded-md border-2 border-base-100 bg-base-200 p-3"
                    >
                        <li
                            :class="{
                                'line-through opacity-50':
                                    $page.props.auth.user !== null,
                            }"
                        >
                            <label
                                v-if="$page.props.auth.user === null"
                                for="account-modal"
                                class="underlined-link ml-1 cursor-pointer select-none"
                                >Sign up<FontAwesomeIcon
                                    class="mx-1 !align-middle"
                                    :icon="faArrowRightLong"
                                    size="xs"
                                />
                            </label>
                            <template v-else>&nbsp;Sign up</template>
                            for an account
                        </li>

                        <li
                            :class="{
                                'line-through opacity-50':
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.connections.length >
                                        0,
                            }"
                        >
                            Connect
                            <FontAwesomeIcon
                                class="mx-0.5 !align-middle"
                                :icon="faPlug"
                                size="xs"
                            />
                            your Steam profile
                        </li>

                        <li
                            :class="{
                                'line-through opacity-50':
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.characters.length !==
                                        0,
                            }"
                        >
                            <template
                                v-if="
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.characters.length !==
                                        0
                                "
                                >&nbsp;Link</template
                            >
                            <LinkButton v-else class="mx-1" disabled />
                            your character
                        </li>
                    </ol>
                </div>
            </div>
            a character to access the<FontAwesomeIcon
                class="mx-1 !align-middle text-gold"
                :icon="faGun"
                size="2xs"
                fixed-width
            />
            <strong>gold-plated variant</strong> of the
            <NormalLink
                href="https://armedassault.fandom.com/wiki/AKS"
                size="2xs"
                >AKS</NormalLink
            >
            and
            <NormalLink
                href="https://armedassault.fandom.com/wiki/Revolver"
                size="2xs"
                >Revolver</NormalLink
            >
        </div>
    </div>
</template>
