<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Characters">
            <div
                role="alert"
                class="alert alert-warning mb-6 flex justify-center rounded-md py-2"
            >
                <span class="text-center">You have no linked characters</span>
            </div>

            <p>
                After creating a
                <Link class="underlined-link" href="/settings/connections"
                    >Connection</Link
                >
                with Steam, eligible characters can be linked from the
                <Link class="underlined-link" :href="route('home')"
                    >Leaderboard</Link
                >
                page.
            </p>
        </Setting>
    </DefaultLayout>
</template>
