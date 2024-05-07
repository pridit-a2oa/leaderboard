<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Features"></Setting>
    </DefaultLayout>
</template>
