<script setup>
import { Link } from '@inertiajs/vue3';
import AppLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="bg-base-200">
        <AppLogo />
    </div>

    <div class="container mx-auto text-neutral-400">
        <main>
            <slot />
        </main>
    </div>

    <div class="bg-base-200">
        <div class="container mx-auto flex justify-center py-6 text-sm">
            <Link class="underlined-link" :href="route('privacy')"
                >Privacy policy</Link
            >

            <div class="ml-auto">
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
    </div>
</template>
