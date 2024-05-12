<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCheck, faXmark } from '@fortawesome/free-solid-svg-icons';
import Setting from '@/Components/Setting.vue';
import Alert from '@/Components/Alert.vue';

const features = ref([
    { type: 'Multiple character linking' },
    { type: 'Reset statistics option (per character)' },
    {
        type: `<span class="tooltip tooltip-bottom tooltip-secondary cursor-pointer underline decoration-dashed underline-offset-4 before:w-[14rem] before:content-[attr(data-tip)]" data-tip="${usePage().props.features.join(', ').toString()}">Additional statistics</span> tracking (while linked)`,
    },
]);

const benefits = usePage().props.permissions.some((role) =>
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
                            <font-awesome-icon
                                class="mr-1"
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
