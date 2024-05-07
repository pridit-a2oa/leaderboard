<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Account">
            <div>
                <span>Change display name</span>
            </div>

            <div>
                <span>Update email address</span>
            </div>

            <div>
                <span>Update password</span>
            </div>
        </Setting>
    </DefaultLayout>
</template>
