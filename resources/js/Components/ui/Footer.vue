<script setup>
import { NormalLink } from '@/Components/links';
import { faGithub } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <footer class="footer bg-base-200">
        <div
            class="xs:px-0 container mx-auto flex flex-col items-center gap-y-4 py-4 text-neutral-300 md:flex-row"
        >
            <div class="flex flex-1 gap-4">
                <a
                    href="https://github.com/pridit-a2oa"
                    target="_blank"
                    aria-label="GitHub"
                >
                    <FontAwesomeIcon :icon="faGithub" size="lg" fixed-width />
                </a>

                <ul class="flex flex-row flex-wrap gap-4">
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
            </div>

            <div>
                <span>&copy; {{ new Date().getFullYear() }}&nbsp;</span>

                <NormalLink href="https://www.pridit.co.uk"
                    >Jordan Heale</NormalLink
                >
            </div>
        </div>
    </footer>
</template>
