<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faCircle,
    faCog,
    faHeart,
    faHeartBroken,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
} from '@fortawesome/vue-fontawesome';

library.add(faCog, faHeart, faHeartBroken);

const path = {
    admin: route('user.setting.dashboard.index'),
    default: route('user.setting.extras'),
};
</script>

<template>
    <div
        class="indicator-item cursor-default"
        :title="
            ($page.props.auth.role.name === 'supporter' &&
                'Thanks for being a supporter!') ||
            ''
        "
    >
        <FontAwesomeLayers v-if="$page.props.auth.role.icon">
            <Link
                :class="{
                    'pointer-events-none': [
                        path[$page.props.auth.role.name],
                        path.default,
                    ].includes($page.props.ziggy.location),
                }"
                :href="path[$page.props.auth.role.name] ?? path.default"
                :as="
                    [path[$page.props.auth.role.name], path.default].includes(
                        $page.props.ziggy.location,
                    )
                        ? 'div'
                        : 'a'
                "
            >
                <FontAwesomeIcon
                    class="z-10 text-neutral-500"
                    :style="{ color: $page.props.auth.role.color }"
                    :icon="$page.props.auth.role.icon"
                />
            </Link>

            <FontAwesomeIcon
                class="text-base-100"
                :icon="faCircle"
                size="2xl"
                transform="left-4"
            />
        </FontAwesomeLayers>
    </div>
</template>
