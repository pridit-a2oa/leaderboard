<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';
import SupporterBadge from '@/Components/SupporterBadge.vue';
import { faCheck, faXmark } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, usePage } from '@inertiajs/vue3';

const features = ref([
    {
        type: '<span class="tooltip-benefit" data-tip="By default, characters must be active within the last 60 days to be displayed in the leaderboard.">Inactivity</span> exemption',
    },
    {
        type: 'Supporter badge (<span class="tooltip-benefit" data-tip="Applies to the linked character with the highest score.">single</span>)',
    },
    { type: 'Multiple character linking' },
    { type: 'Reset statistics option (per character)' },
    {
        type: `<span class="tooltip-benefit" data-tip="${usePage().props.features.join(', ').toString()}">Additional statistics</span> tracking (while linked)`,
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
            <a v-if="!benefits" href="https://ko-fi.com/pridit" target="_blank">
                <Alert
                    type="info"
                    message="Support on Ko-fi to unlock additional features"
                />
            </a>

            <div class="indicator w-full rounded-md bg-base-200 p-4">
                <SupporterBadge
                    v-if="$page.props.roles.includes('supporter')"
                />

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
