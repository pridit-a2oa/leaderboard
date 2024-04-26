<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    characters: {
        type: Object,
    },
});
</script>

<template>
    <main class="container mx-auto">
        <Head title="Leaderboard" />

        <Navigation />

        <div v-if="characters.data.length > 0" class="overflow-x-auto pb-10">
            <table class="table border-separate">
                <thead>
                    <tr class="bg-base-100">
                        <th class="w-0">Rank</th>
                        <th>Name</th>
                        <th>Score</th>
                    </tr>
                </thead>

                <tbody class="bg-base-300 rounded-full">
                    <tr v-for="(character, key) in characters.data"
                        :key="character.id"
                    >
                        <td class="font-bold flex justify-center">
                            {{ key + ((characters.current_page - 1) * characters.per_page) + 1 }}
                        </td>

                        <td>
                            <!-- <font-awesome-icon :icon="['fas', 'medal']" /> -->
                            {{ character.name }}
                        </td>

                        <td>
                            {{ character.score }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="flex flex-col w-full">
            <div class="divider">No records found</div>
        </div>

        <Pagination :links="characters.links" />
    </main>
</template>
