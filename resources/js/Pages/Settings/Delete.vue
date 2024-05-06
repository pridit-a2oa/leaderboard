<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Delete Account">
            <p>
                Please note that this action is
                <span class="font-bold underline">irreversible</span>
                and your account
                <span class="font-bold underline">cannot</span> be restored.
            </p>

            <br />

            <p>By performing an account deletion the following will occur:</p>

            <br />

            <ul
                class="ml-4 flex list-outside list-disc flex-wrap font-semibold"
            >
                <li>Your email address can be re-used</li>
                <li>Any linked characters will be unlinked</li>
                <li>Any connections will be severed (e.g. Steam)</li>
                <li>Ko-fi contribution will be unassociated (if associated)</li>
            </ul>

            <br />

            <p>Are you sure you want to delete your account?</p>

            <br />

            <button class="btn btn-error btn-sm text-black">
                <font-awesome-icon :icon="['fas', 'trash']" size="sm" />
                Delete my account
            </button>
        </Setting>
    </DefaultLayout>
</template>
