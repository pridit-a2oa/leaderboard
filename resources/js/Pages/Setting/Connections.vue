<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Setting from '@/Components/Setting.vue';
import Alert from '@/Components/Alert.vue';

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
            <Alert
                v-if="$page.props.flash.message"
                :type="$page.props.flash.message[0]"
                :message="$page.props.flash.message[1]"
            />

            <table class="table border-collapse rounded-md bg-base-200">
                <tbody>
                    <tr
                        v-for="connection in connections.sort((a, b) =>
                            a.name > b.name ? 1 : -1,
                        )"
                        :key="connection.id"
                    >
                        <td class="w-0 text-center">
                            <font-awesome-icon
                                :icon="['brands', connection.name]"
                                size="2xl"
                                fixed-width
                            />
                        </td>

                        <td class="p-0 font-semibold capitalize">
                            {{ connection.name }}
                            <span
                                class="block text-sm font-normal text-neutral-500"
                            >
                                {{
                                    $page.props.auth.user.connections
                                        .filter(
                                            (e) =>
                                                e.pivot.connection_id ===
                                                connection.id,
                                        )
                                        .map((e) => e.pivot.identifier)
                                        .toString()
                                }}</span
                            >
                        </td>

                        <td class="text-right">
                            <Link
                                v-if="
                                    $page.props.auth.user.connections.some(
                                        (e) =>
                                            e.pivot.connection_id ===
                                            connection.id,
                                    )
                                "
                                :href="route('user.disconnect')"
                                method="post"
                                :data="{
                                    connection_id: connection.id,
                                }"
                                class="badge badge-error badge-outline select-none font-light uppercase"
                            >
                                Disconnect
                            </Link>

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
