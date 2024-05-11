<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCheck, faXmark } from '@fortawesome/free-solid-svg-icons';
import Setting from '@/Components/Setting.vue';
import Alert from '@/Components/Alert.vue';

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
                v-if="
                    $page.props.permissions.some((role) =>
                        ['admin', 'supporter'].includes(role),
                    )
                "
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
                        <li
                            v-if="
                                $page.props.permissions.some((role) =>
                                    ['admin', 'supporter'].includes(role),
                                ) || feature.supporter
                            "
                            class="[&:not(:last-child)]:mb-2"
                        >
                            <font-awesome-icon
                                class="text-red-500"
                                :class="{
                                    '!text-green-500':
                                        $page.props.permissions.some((role) =>
                                            ['admin', 'supporter'].includes(
                                                role,
                                            ),
                                        ) || !feature.supporter,
                                }"
                                :icon="
                                    $page.props.permissions.some((role) =>
                                        ['admin', 'supporter'].includes(role),
                                    ) || !feature.supporter
                                        ? faCheck
                                        : faXmark
                                "
                                fixed-width
                            />

                            {{ feature.type }}
                        </li>
                    </template>
                </ul>
            </div>
        </Setting>
    </DefaultLayout>
</template>
