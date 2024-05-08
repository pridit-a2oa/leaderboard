<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';

defineProps({
    connections: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Settings" />

    <DefaultLayout>
        <Setting title="Connections">
            <table class="table border-collapse">
                <tbody>
                    <tr
                        v-for="connection in connections.sort((a, b) =>
                            a.name > b.name ? 1 : -1,
                        )"
                        :key="connection.id"
                    >
                        <td class="w-0 pl-0 text-center">
                            <font-awesome-icon
                                :icon="['brands', connection.name]"
                                size="2xl"
                                fixed-width
                            />
                        </td>

                        <td class="p-0 font-semibold capitalize">
                            {{ connection.name }}
                        </td>

                        <td class="text-right">
                            <button
                                v-if="
                                    $page.props.auth.user.connections.some(
                                        (e) => e.name === connection.name,
                                    )
                                "
                                class="badge badge-error badge-outline select-none font-light uppercase"
                            >
                                Disconnect
                            </button>

                            <Link
                                v-else
                                :href="route('connect')"
                                class="badge badge-primary badge-outline select-none font-light uppercase"
                            >
                                Connect
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Setting>
    </DefaultLayout>
</template>
