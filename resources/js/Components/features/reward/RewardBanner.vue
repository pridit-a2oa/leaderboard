<script setup>
import { LinkButton } from '@/Components/buttons';
import { LinkBadge } from '@/Components/features/character';
import { RewardIcon } from '@/Components/features/reward';
import { NormalLink } from '@/Components/links';
import { faGun, faPlug } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="alert mb-6 hidden rounded-lg md:grid" role="alert">
        <RewardIcon :user="$page.props.auth.user" />

        <div class="text-sm">
            <div class="dropdown dropdown-hover">
                <span class="tooltip-benefit">Link</span>

                <div class="dropdown-content z-20 w-max">
                    <ol
                        class="mt-2 flex list-inside list-decimal flex-col gap-3.5 rounded-md border-2 border-base-100 bg-base-200 p-3"
                    >
                        <li
                            :class="{
                                'line-through opacity-50':
                                    $page.props.auth.user !== null,
                            }"
                        >
                            <template v-if="$page.props.auth.user !== null">
                                Sign up
                            </template>
                            <LinkButton v-else class="mx-1">
                                <label
                                    for="account-modal"
                                    class="cursor-pointer"
                                    >Sign up</label
                                >
                            </LinkButton>
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
                            Create
                            <template
                                v-if="
                                    $page.props.auth.user !== null &&
                                    $page.props.auth.user.connections.length > 0
                                "
                            >
                                connection
                            </template>
                            <Link
                                v-else
                                class="btn btn-xs mx-0.5 rounded-md bg-base-100 p-0 px-2 align-middle"
                                :href="
                                    $page.props.auth.user !== null
                                        ? route('user.setting.connections')
                                        : '#'
                                "
                            >
                                <FontAwesomeIcon :icon="faPlug" size="xs" />
                                Connection
                            </Link>

                            to Steam
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
                            >
                                Link
                            </template>
                            <LinkBadge v-else class="mx-1" disabled />
                            your character
                        </li>
                    </ol>
                </div>
            </div>
            a character to access the<FontAwesomeIcon
                class="mx-1 !align-middle text-amber-400"
                :icon="faGun"
                size="2xs"
                fixed-width
            />
            <strong>gold-plated variant</strong> of the
            <NormalLink href="https://armedassault.fandom.com/wiki/AKS"
                >AKS</NormalLink
            >
            and
            <NormalLink href="https://armedassault.fandom.com/wiki/Revolver"
                >Revolver</NormalLink
            >
        </div>
    </div>
</template>
