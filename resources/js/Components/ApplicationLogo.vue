<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="navbar justify-center py-6 text-neutral-300">
        <h1 class="text-xl">
            <Link
                :href="route('home')"
                class="inline-flex items-center justify-center"
            >
                <img class="mr-4 h-10" src="/images/logo.png" alt="Logo" />

                Pridit's Domination Takistan
            </Link>
        </h1>
    </div>
</template>
