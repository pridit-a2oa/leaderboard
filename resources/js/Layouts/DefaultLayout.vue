<script setup>
import { AccountModal } from '@/Components/features/auth';
import { Banner, Breadcrumbs, Footer } from '@/Components/ui';
</script>

<template>
    <AccountModal />

    <div class="flex h-screen flex-col">
        <Banner />

        <Breadcrumbs />

        <main class="container mx-auto my-8 flex-grow text-neutral-400">
            <slot />
        </main>

        <Footer />
    </div>
</template>
