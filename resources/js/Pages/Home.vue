<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { RewardBanner } from '@/Components/features/reward';
import { CharactersTable } from '@/Components/tables';
import { Navbar, Pagination } from '@/Components/ui';
import { Head } from '@inertiajs/vue3';

defineProps({
    characters: {
        type: Object,
    },
});
</script>

<template>
    <DefaultLayout>
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

        <div v-if="characters.data.length > 0" class="mt-4 font-bold">
            <CharactersTable :characters="characters" />
        </div>

        <div v-else class="mt-8 flex w-full flex-col">
            <div class="divider">No records found</div>
        </div>

        <Pagination :meta="characters.meta" />
    </DefaultLayout>
</template>
