<script setup>
import { AccountModal } from '@/Components/features/auth';
import { Banner, Breadcrumbs, Footer } from '@/Components/ui';
</script>

<template>
    <AccountModal />

    <div class="flex h-screen flex-col">
        <Banner />

        <Breadcrumbs v-if="$page.props.name" />

        <main class="container mx-auto my-8 flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
