<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faHouse, faCog, faFile } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faCog, faFile);

const icon = usePage().props.icon;
</script>

<template>
    <div class="flex bg-base-300 text-sm">
        <div class="container breadcrumbs mx-auto py-4">
            <ul>
                <li>
                    <Link class="underlined-link" :href="route('home')">
                        <FontAwesomeIcon
                            class="mr-1.5"
                            :icon="faHouse"
                            size="sm"
                            fixed-width
                        />

                        Home
                    </Link>
                </li>

                <li class="text-neutral-300">
                    <FontAwesomeIcon
                        class="mr-1.5"
                        :icon="icon"
                        size="sm"
                        fixed-width
                    />

                    {{ $page.props.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
