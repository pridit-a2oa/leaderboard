<script setup>
import { NormalLink } from '@/Components/links';
import { faGithub } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="footer bg-base-200">
        <div
            class="container mx-auto flex justify-center py-6 text-neutral-300"
        >
            <a href="https://github.com/pridit-a2oa" target="_blank">
                <FontAwesomeIcon :icon="faGithub" size="lg" fixed-width />
            </a>

            <ul class="inline-flex gap-3">
                <li>
                    <Link class="underlined-link" :href="route('terms')">
                        Terms of Use
                    </Link>
                </li>

                <li>
                    <Link class="underlined-link" :href="route('privacy')">
                        Privacy Policy
                    </Link>
                </li>
            </ul>

            <div class="ml-auto self-center">
                <span>&copy; {{ new Date().getFullYear() }}&nbsp;</span>

                <NormalLink href="https://www.pridit.co.uk"
                    >Jordan Heale</NormalLink
                >
            </div>
        </div>
    </footer>
</template>
