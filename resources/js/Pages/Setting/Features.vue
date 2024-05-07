<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref, watchEffect } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
import Alert from '@/Components/Alert.vue';

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
            <Alert
                v-if="is('admin | supporter')"
                type="success"
                message="Thanks for being a supporter"
            />

            <a v-else href="https://ko-fi.com/pridit" target="_blank">
                <Alert
                    type="info"
                    message="Support on Ko-fi to unlock additional features"
                />
            </a>

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

            <p></p>
        </Setting>
    </DefaultLayout>
</template>
