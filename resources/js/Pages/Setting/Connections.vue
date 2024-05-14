<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import Setting from '@/Components/Setting.vue';
import { DisconnectButton } from '@/Components/Submit';

import { faSteam } from '@fortawesome/free-brands-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, Link } from '@inertiajs/vue3';

library.add(faSteam);

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
                v-if="$page.props.flash.message.length > 0"
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
                            <FontAwesomeIcon
                                :icon="['fab', connection.icon]"
                                size="2xl"
                                fixed-width
                            />
                        </td>

                        <td class="p-0 font-semibold capitalize">
                            {{ connection.name
                            }}<span
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
                            <div
                                v-if="
                                    $page.props.auth.user.connections.some(
                                        (e) =>
                                            e.pivot.connection_id ===
                                            connection.id,
                                    )
                                "
                                class="tooltip tooltip-bottom tooltip-error before:w-[18rem]"
                                data-tip="This action will unlink any linked characters"
                            >
                                <DisconnectButton :id="connection.id" />
                            </div>

                            <Link
                                v-else
                                :href="route(`connection.${connection.name}`)"
                                class="badge badge-success badge-outline select-none font-light uppercase"
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
