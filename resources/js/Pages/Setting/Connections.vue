<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { DisconnectButton } from '@/Components/features/character';
import { UserSettings } from '@/Components/features/user';
import { Alert } from '@/Components/ui';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import { faCircleQuestion } from '@fortawesome/free-regular-svg-icons';
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
        <UserSettings title="Connections">
            <Alert
                v-if="$page.props.flash.message.length > 0"
                :type="$page.props.flash.message[0]"
                :message="$page.props.flash.message[1]"
            />

            <table class="table border-collapse rounded-md bg-base-200">
                <tbody>
                    <tr
                        v-for="connection in connections.data.sort((a, b) =>
                            a.name > b.name ? 1 : -1,
                        )"
                        :key="connection.id"
                        class="border-base-100 [&:not(:last-child)]:!border-b-4"
                    >
                        <td class="w-0 text-center">
                            <FontAwesomeIcon
                                :icon="['fab', connection.icon]"
                                size="2xl"
                                fixed-width
                            />
                        </td>

                        <td class="p-0">
                            <span class="font-semibold">
                                {{ connection.formatted_name }}
                            </span>

                            <span
                                v-if="connection.disclaimer"
                                class="tooltip tooltip-bottom tooltip-secondary ml-1 cursor-pointer rounded-full text-neutral-400 before:w-[17rem]"
                                :data-tip="connection.disclaimer"
                            >
                                <FontAwesomeIcon
                                    class="!align-middle"
                                    :icon="faCircleQuestion"
                                    fixed-width
                                />
                            </span>

                            <span
                                class="block text-sm font-normal text-neutral-600"
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
                                class="tooltip tooltip-bottom tooltip-error before:w-[10rem]"
                                data-tip="This action will unlink any linked characters"
                            >
                                <DisconnectButton :id="connection.id" />
                            </div>

                            <div
                                v-else
                                class="tooltip tooltip-bottom tooltip-secondary before:w-[12rem]"
                                :data-tip="`You will be taken to ${connection.formatted_name} to complete this process`"
                            >
                                <Link
                                    :href="
                                        route(`connection.${connection.name}`)
                                    "
                                    class="badge badge-success badge-outline select-none font-light uppercase"
                                >
                                    Connect
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </UserSettings>
    </DefaultLayout>
</template>
