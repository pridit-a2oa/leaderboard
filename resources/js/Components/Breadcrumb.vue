<script setup>
import { Link } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHouse, faCog, faFile } from '@fortawesome/free-solid-svg-icons';

library.add(faCog, faFile);
</script>

<template>
    <div v-if="$page.component !== 'Home'" class="flex bg-base-300 text-sm">
        <div class="container breadcrumbs mx-auto py-4">
            <ul>
                <li>
                    <Link class="underlined-link" :href="route('home')">
                        <font-awesome-icon
                            class="mr-1.5"
                            :icon="faHouse"
                            size="sm"
                            fixed-width
                        />

                        Home
                    </Link>
                </li>

                <li class="text-neutral-300">
                    <font-awesome-icon
                        class="mr-1.5"
                        :icon="$page.props.icon"
                        size="sm"
                        fixed-width
                    />

                    {{ $page.props.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
