<script setup>
import { Banner, Breadcrumbs, Footer } from '@/Components/ui';
</script>

<template>
    <div class="flex h-screen flex-col">
        <Banner />

        <Breadcrumbs />

        <main class="container mx-auto my-8 flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
