<script setup>
import ExternalLink from '@/Components/ExternalLink.vue';
import {
    faPersonRifle,
    faGun,
    faCircleCheck,
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
            <span
                class="tooltip-benefit before:whitespace-pre-line"
                data-tip="1. Register an account&#10;2. Connect your Steam via: Account > Settings > Connections&#10;3. Link your character below"
                >Link</span
            >
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
