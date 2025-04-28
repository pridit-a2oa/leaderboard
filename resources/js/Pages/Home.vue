<script setup>
import { RewardBanner } from '@/Components/features/reward';
import { CharactersTable } from '@/Components/tables';
import { Navbar } from '@/Components/ui';
import { Head, WhenVisible } from '@inertiajs/vue3';

defineProps({
    characters: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Leaderboard">
        <meta
            name="description"
            content="Track and compare your score with the rest of the community"
        />

        <!-- Open Graph -->
        <meta property="og:title" content="Leaderboard" />
        <meta
            property="og:description"
            content="Track and compare your score with the rest of the community"
        />
        <meta
            property="og:image"
            content="https://arma.pridit.co.uk/images/logo.png"
        />
    </Head>

    <RewardBanner />

    <Navbar />

    <div v-if="characters.data.length > 0" class="font-bold">
        <CharactersTable :characters="characters" />

        <WhenVisible
            v-if="
                characters.meta &&
                characters.data.length < characters.meta.total
            "
            :always="characters.meta.current_page < characters.meta.last_page"
            :buffer="300"
            :params="{
                data: {
                    page: characters.meta.current_page + 1,
                },
                only: ['characters'],
                preserveUrl: true,
            }"
        />
    </div>
</template>
