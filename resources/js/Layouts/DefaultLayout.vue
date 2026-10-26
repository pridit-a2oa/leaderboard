<script setup>
import { Banner, Breadcrumbs, Footer } from '@/Components/ui';
</script>

<template>
    <div
        class="flex h-dvh flex-col [&>*]:[scrollbar-gutter:stable_both-edges] [&>*]:overflow-x-hidden [&>*]:max-md:px-4"
    >
        <Banner />

        <Breadcrumbs />

        <main class="flex-1 overflow-y-auto" scroll-region>
            <div class="container mx-auto grid gap-5 py-8">
                <slot />
            </div>
        </main>

        <Footer />
    </div>
</template>
