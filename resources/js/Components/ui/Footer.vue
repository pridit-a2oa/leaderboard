<script setup>
import { NormalLink } from '@/Components/links';
import { faGithub } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <footer class="footer bg-base-200">
        <div
            class="container mx-auto flex flex-wrap justify-center gap-y-4 px-2 py-6 text-neutral-300 xs:px-0"
        >
            <a
                href="https://github.com/pridit-a2oa"
                target="_blank"
                aria-label="GitHub"
            >
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

            <div class="self-center xs:ml-auto">
                <span>&copy; {{ new Date().getFullYear() }}&nbsp;</span>

                <NormalLink href="https://www.pridit.co.uk"
                    >Jordan Heale</NormalLink
                >
            </div>
        </div>
    </footer>
</template>
