<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Characters">
            <Alert type="warning" message="You have no linked characters" />
        </Setting>
    </DefaultLayout>
</template>
