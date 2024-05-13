<script setup>
import AppLogo from '@/Components/ApplicationLogo.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';
import { faGithub } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex h-screen flex-col">
        <div class="bg-base-200">
            <AppLogo />
        </div>

        <Breadcrumb v-if="$page.props.name" />

        <main class="container mx-auto my-6 flex-grow text-neutral-400">
            <slot />
        </main>

        <footer class="footer bg-base-200">
            <div class="container mx-auto flex justify-center py-6">
                <a href="https://github.com/pridit-a2oa" target="_blank">
                    <FontAwesomeIcon
                        class="!align-middle"
                        :icon="faGithub"
                        fixed-width
                    />
                </a>

                <Link class="underlined-link" :href="route('privacy')"
                    >Privacy policy</Link
                >

                <div class="ml-auto self-center text-xs">
                    <span>&copy; {{ new Date().getFullYear() }}&nbsp;</span>
                    <a
                        class="underlined-link"
                        href="https://www.pridit.co.uk"
                        target="_blank"
                        >Jordan Heale</a
                    ><FontAwesomeIcon
                        class="ml-1 !align-middle"
                        :icon="faArrowUpRightFromSquare"
                        size="2xs"
                    />
                </div>
            </div>
        </footer>
    </div>
</template>
