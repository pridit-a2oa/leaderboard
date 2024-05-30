<script setup>
import AppBanner from '@/Components/ApplicationBanner.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';
import { faGithub } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex h-screen flex-col">
        <AppBanner />

        <Breadcrumb v-if="$page.props.name" />

        <main class="container mx-auto my-8 flex-grow">
            <slot />
        </main>

        <footer class="footer bg-base-200">
            <div
                class="container mx-auto flex justify-center py-6 text-xs text-neutral-300"
            >
                <a href="https://github.com/pridit-a2oa" target="_blank">
                    <FontAwesomeIcon :icon="faGithub" size="lg" fixed-width />
                </a>

                <ul class="inline-flex gap-3">
                    <li>
                        <Link class="underlined-link" :href="route('terms')"
                            >Terms of Use</Link
                        >
                    </li>

                    <li>
                        <Link class="underlined-link" :href="route('privacy')"
                            >Privacy Policy</Link
                        >
                    </li>
                </ul>

                <div class="ml-auto self-center">
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
