<script setup>
import { DisconnectBadge } from '@/Components/features/character';
import { UserSettings } from '@/Components/features/user';
import { NormalLink } from '@/Components/links';
import { Alert } from '@/Components/ui';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSteam } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/vue3';
import { defineCustomElement } from 'vue';

library.add(faSteam);

defineProps({
    connections: {
        type: Object,
    },
});

if (!customElements.get('component-link')) {
    customElements.define(
        'component-link',
        defineCustomElement({
            shadowRoot: false,
            props: ['title'],
            components: {
                NormalLink,
            },
            template: `<NormalLink>{{ title }}</NormalLink>`,
        }),
    );
}
</script>

<template>
    <Head title="Settings &#x2022; Connections" />

    <UserSettings title="Connections">
        <Alert
            v-if="$page.props.flash.message.length > 0"
            :type="$page.props.flash.message[0]"
            :message="$page.props.flash.message[1]"
        />

        <template
            v-for="connection in connections.data.sort((a, b) =>
                a.name > b.name ? 1 : -1,
            )"
            :key="connection.id"
        >
            <table class="bg-base-200 mb-2 table table-fixed rounded-md">
                <tbody>
                    <tr>
                        <td class="w-0 text-center">
                            <FontAwesomeIcon
                                :icon="['fab', connection.icon]"
                                size="xl"
                                fixed-width
                            />
                        </td>

                        <td class="p-0 pl-6">
                            <span>
                                {{ connection.formatted_name }}
                            </span>

                            <span
                                class="block text-xs font-normal text-neutral-600 tabular-nums"
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
                                }}
                            </span>
                        </td>

                        <td class="text-right">
                            <template
                                v-if="
                                    $page.props.auth.user.connections.some(
                                        (e) =>
                                            e.pivot.connection_id ===
                                            connection.id,
                                    )
                                "
                            >
                                <span
                                    v-if="connection.is_oauth"
                                    class="badge badge-soft badge-md cursor-not-allowed text-xs font-light uppercase opacity-50 select-none"
                                    title="This connection is required to sign in"
                                >
                                    Disconnect
                                </span>

                                <DisconnectBadge v-else :id="connection.id" />
                            </template>

                            <div
                                v-else
                                class="tooltip tooltip-bottom tooltip-secondary before:w-[12rem]"
                                :data-tip="`You will be redirected to ${connection.formatted_name} to complete this process`"
                            >
                                <Link
                                    :href="
                                        route(`connection.${connection.name}`)
                                    "
                                    class="badge badge-success badge-soft text-xs font-light uppercase select-none"
                                >
                                    Connect
                                </Link>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="connection.description">
                        <td
                            colspan="3"
                            class="bg-base-300/50 border-base-300 rounded-b-md border-t-1 pt-2.5"
                        >
                            <span v-html="connection.description"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
    </UserSettings>
</template>
