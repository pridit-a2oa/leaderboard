<script setup>
import ExternalLink from '@/Components/ExternalLink.vue';
import { LinkButton } from '@/Components/Submit';
import {
    faPersonRifle,
    faCircleCheck,
    faArrowRightLong,
    faPlug,
    faGun,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div role="alert" class="alert mb-6 rounded-lg">
        <FontAwesomeLayers class="indicator mr-1">
            <FontAwesomeIcon :icon="faPersonRifle" fixed-width />
            <FontAwesomeIcon
                v-if="
                    $page.props.auth.user !== null &&
                    $page.props.auth.user.connections.length !== 0 &&
                    $page.props.auth.user.characters.length !== 0
                "
                :icon="faCircleCheck"
                size="sm"
                fixed-width
                class="indicator-item indicator-end indicator-bottom rounded-full bg-base-200 p-0 py-0.5 text-green-700"
                transform="shrink-2"
            />
        </FontAwesomeLayers>

        <div class="text-sm">
            <div class="dropdown dropdown-hover">
                <span class="tooltip-benefit">Link</span>

                <div class="dropdown-content z-[1] w-max">
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
                                for="modal"
                                class="underlined-link ml-1 cursor-pointer select-none"
                                >Sign up<FontAwesomeIcon
                                    class="mx-1 !align-middle"
                                    :icon="faArrowRightLong"
                                    size="xs"
                                />
                            </label>

                            <span v-else>&nbsp;Sign up</span>

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
                            <LinkButton
                                class="mx-1"
                                :class="{
                                    '!badge-neutral':
                                        $page.props.auth.user !== null &&
                                        $page.props.auth.user.characters
                                            .length !== 0,
                                }"
                                disabled
                            />
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
            <ExternalLink href="https://armedassault.fandom.com/wiki/AKS"
                >AKS</ExternalLink
            >
            and
            <ExternalLink href="https://armedassault.fandom.com/wiki/Revolver"
                >Revolver</ExternalLink
            >
        </div>
    </div>
</template>
