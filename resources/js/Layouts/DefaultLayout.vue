<script setup>
import { Banner, Breadcrumbs, Footer } from '@/Components/ui';
</script>

<template>
    <div class="flex h-screen flex-col">
        <Banner />

        <Breadcrumbs />

        <main class="container mx-auto mb-auto grid gap-5 py-8">
            <slot />
        </main>

        <Footer />
    </div>
</template>
