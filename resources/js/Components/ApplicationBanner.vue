<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-base-200">
        <div class="navbar justify-center bg-base-200 py-6 text-neutral-300">
            <h1 class="text-xl">
                <Link :href="route('home')" class="inline-flex items-center">
                    <img class="mr-4 h-10" src="/images/logo.png" alt="Logo" />

                    {{ $page.props.app.name }}
                </Link>
            </h1>
        </div>
    </div>
</template>
