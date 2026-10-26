<script setup>
import { UserNavigation } from '@/Components/features/user';
import { ButtonLink } from '@/Components/links';
import { faDiscord } from '@fortawesome/free-brands-svg-icons';
import { faBullhorn, faHeart } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div
        class="grid grid-cols-[repeat(3,max-content)_1fr] items-center gap-3 max-xs:!grid-cols-1 max-md:grid-cols-[1fr_1fr]"
    >
        <ButtonLink href="https://dsc.gg/pridit">
            <FontAwesomeIcon
                class="pr-0.5 text-[#7289da]"
                :icon="faDiscord"
                size="sm"
            />
            Discord
        </ButtonLink>

        <ButtonLink href="https://feedback.pridit.co.uk">
            <FontAwesomeIcon
                class="pr-0.5 text-yellow-600"
                :icon="faBullhorn"
                size="sm"
            />
            Feedback
        </ButtonLink>

        <ButtonLink href="https://ko-fi.com/pridit">
            <FontAwesomeIcon
                class="pr-0.5 text-[#ff6433]"
                :icon="faHeart"
                size="sm"
            />
            Ko-fi
        </ButtonLink>

        <UserNavigation v-if="$page.props.auth.user !== null" />

        <Link
            v-else
            class="place-self-center select-none xs:justify-self-end"
            :href="route('login')"
            data-test="login"
        >
            <img
                src="/images/sits_01.png"
                alt="Sign in through Steam"
                loading="lazy"
            />
        </Link>
    </div>
</template>
