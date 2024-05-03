<script setup>
import { Link } from '@inertiajs/vue3';
import ExtLink from '@/Components/ExtLink.vue';
import Login from '@/Components/Modal/Login.vue';
</script>

<template>
    <div class="xs:flex-row mt-8 flex flex-col justify-between gap-3">
        <ExtLink
            class="text-[#7289da]"
            href="https://dsc.gg/pridit"
            :icon="['brands', 'discord']"
            >Discord</ExtLink
        >

        <ExtLink
            class="text-yellow-600"
            href="https://feedback.pridit.co.uk"
            :icon="['fas', 'bullhorn']"
            >Feedback</ExtLink
        >

        <ExtLink
            class="text-[#ff5c5a]"
            href="https://ko-fi.com/pridit"
            :icon="['fas', 'heart']"
            >Ko-fi</ExtLink
        >

        <Login />
    </div>
</template>
