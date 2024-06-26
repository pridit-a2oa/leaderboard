<script setup>
import { UserNavigation } from '@/Components/features/user';
import { ButtonLink } from '@/Components/links';
import {
    faBullhorn,
    faHeart,
    faRightToBracket,
} from '@fortawesome/free-solid-svg-icons';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
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

        <UserNavigation v-if="$page.props.auth.user !== null" />

        <label
            v-else
            for="account-modal"
            class="btn no-animation ml-auto hidden md:inline-flex"
            role="button"
            tabindex="0"
            dusk="login-button"
        >
            <FontAwesomeIcon :icon="faRightToBracket" size="sm" />
            Sign in
        </label>
    </div>
</template>
