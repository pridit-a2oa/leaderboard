<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCheck, faXmark, faHeart } from '@fortawesome/free-solid-svg-icons';
import { Head, usePage } from '@inertiajs/vue3';

const features = ref([
    {
        type: '<span class="tooltip tooltip-bottom tooltip-secondary cursor-pointer underline decoration-dashed decoration-1 underline-offset-4 before:w-[14rem] before:content-[attr(data-tip)]" data-tip="By default, only characters active within the last 60 days are displayed in the leaderboard. With this benefit, all linked characters remain visible.">Inactivity</span> exemption',
    },
    { type: 'Multiple character linking' },
    { type: 'Reset statistics option (per character)' },
    {
        type: `<span class="tooltip tooltip-bottom tooltip-secondary cursor-pointer underline decoration-dashed decoration-1 underline-offset-4 before:w-[14rem] before:content-[attr(data-tip)]" data-tip="${usePage().props.features.join(', ').toString()}">Additional statistics</span> tracking (while linked)`,
    },
]);

const benefits = usePage().props.roles.some((role) =>
    ['admin', 'supporter'].includes(role),
);
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Features">
            <Alert
                v-if="benefits"
                type="success"
                message="Thanks for being a supporter"
            />

            <a v-else href="https://ko-fi.com/pridit" target="_blank">
                <Alert
                    type="info"
                    message="Support on Ko-fi to unlock additional features"
                />
            </a>

            <div class="rounded-md bg-base-200 p-4">
                <ul>
                    <template v-for="feature in features">
                        <li class="[&:not(:last-child)]:mb-2">
                            <FontAwesomeIcon
                                class="mr-1 !align-middle"
                                :class="[
                                    benefits
                                        ? 'text-green-500'
                                        : 'text-red-500',
                                ]"
                                :icon="benefits ? faCheck : faXmark"
                                fixed-width
                            />

                            <span v-html="feature.type"></span>
                        </li>
                    </template>
                </ul>
            </div>
        </Setting>
    </DefaultLayout>
</template>
