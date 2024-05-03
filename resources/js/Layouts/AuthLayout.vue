<script setup>
import AppLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0"
    >
        <AppLogo />

        <main>
            <slot />
        </main>
    </div>
</template>
