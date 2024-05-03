<script setup>
import AppLogo from '@/Components/ApplicationLogo.vue';
import AnchorExternal from '@/Components/AnchorExternal.vue';
</script>

<template>
    <div class="navbar mt-4 justify-center bg-neutral text-neutral-300">
        <h1 class="text-xl">
            <AppLogo />
            Pridit's Domination Takistan
        </h1>
    </div>

    <div class="mt-6 flex justify-center">
        <AnchorExternal
            class="text-[#7289da]"
            href="https://dsc.gg/pridit"
            :icon="['brands', 'discord']"
            >Discord</AnchorExternal
        >

        <AnchorExternal
            class="text-yellow-600"
            href="https://feedback.pridit.co.uk"
            :icon="['fas', 'bullhorn']"
            >Feedback</AnchorExternal
        >

        <AnchorExternal
            class="text-[#ff5c5a]"
            href="https://ko-fi.com/pridit"
            :icon="['fas', 'heart']"
            >Ko-fi</AnchorExternal
        >
    </div>
</template>
