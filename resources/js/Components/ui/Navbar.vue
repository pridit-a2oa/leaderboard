<script setup>
import { UserNavigation } from '@/Components/features/user';
import { ButtonLink } from '@/Components/links';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { faBullhorn, faHeart } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div
        class="grid items-center gap-3 md:grid-cols-[auto_auto_auto_1fr] md:justify-start"
    >
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
            <FontAwesomeIcon class="text-[#ff6433]" :icon="faHeart" size="sm" />
            Ko-fi
        </ButtonLink>

        <UserNavigation v-if="$page.props.auth.user !== null" />

        <Link
            v-else
            class="hidden justify-self-end pr-0.5 select-none md:inline-grid"
            :href="route('login')"
            dusk="login-button"
        >
            <img
                src="/images/sits_01.png"
                alt="Sign in through Steam"
                loading="lazy"
            />
        </Link>
    </div>
</template>
