<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref, watchEffect } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';

watchEffect(() => {
    window.Laravel.jsPermissions = usePage().props.permissions;
});

const features = ref([
    { type: 'Single character linking', supporter: false },
    { type: 'Multiple character linking', supporter: true },
    { type: 'Reset statistics option (per character)', supporter: true },
    { type: 'Additional statistics tracking (while linked)', supporter: true },
]);
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Features">
            <ul v-for="feature in features">
                <li v-if="is('member') || feature.supporter" class="mb-2">
                    <font-awesome-icon
                        class="text-red-500"
                        :class="{
                            '!text-green-500':
                                is('admin | supporter') || !feature.supporter,
                        }"
                        :icon="[
                            'fas',
                            is('admin | supporter') || !feature.supporter
                                ? 'check'
                                : 'xmark',
                        ]"
                        fixed-width
                    />

                    {{ feature.type }}
                </li>
            </ul>
        </Setting>
    </DefaultLayout>
</template>
