<script setup>
import { LinkBadge } from '@/Components/features/character';
import { RewardIcon } from '@/Components/features/reward';
import { NormalLink } from '@/Components/links';
import { Tooltip } from '@/Components/ui';
import { faGun } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div
        class="alert hidden rounded-lg border-base-200 bg-base-200 md:grid"
        role="alert"
    >
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
                            Sign in through
                            <template v-if="$page.props.auth.user !== null">
                                Steam
                            </template>
                            <template v-else>
                                <NormalLink
                                    href="https://store.steampowered.com/"
                                    >Steam</NormalLink
                                >
                            </template>
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
            a character to access
            <FontAwesomeIcon
                class="mx-1 !align-middle text-amber-400"
                :icon="faGun"
                size="2xs"
                fixed-width
            />
            <strong>gold-plated variants</strong> of the
            <Tooltip path="/images/gold/aks" alt="Gold AKS">AKS</Tooltip>
            and
            <Tooltip path="/images/gold/revolver" alt="Gold Revolver"
                >Revolver</Tooltip
            >
        </div>
    </div>
</template>
