<script setup>
import { Link } from '@inertiajs/vue3';
import AppLogo from '@/Components/ApplicationLogo.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
</script>

<template>
    <div class="flex h-screen flex-col">
        <div class="bg-base-200">
            <AppLogo />
        </div>

        <Breadcrumb />

        <div class="container mx-auto flex-grow text-neutral-400">
            <main class="my-6">
                <slot />
            </main>
        </div>

        <footer class="footer bg-base-200">
            <div class="container mx-auto flex justify-center py-6">
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
                    ><font-awesome-icon
                        class="ml-1 !align-middle"
                        :icon="['fas', 'arrow-up-right-from-square']"
                        size="2xs"
                    />
                </div>
            </div>
        </footer>
    </div>
</template>
