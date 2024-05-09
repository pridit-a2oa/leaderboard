import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core';

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

/* import specific icons */
import { faDiscord, faSteam } from '@fortawesome/free-brands-svg-icons';
import { faEye, faEyeSlash, faRotate, faUserSlash, faLock, faXmark, faCheck, faTriangleExclamation, faFile, faHouse, faTrash, faBars, faBan, faPlug, faAngleUp, faAngleDown, faRightFromBracket, faGear, faUser, faRightToBracket, faTrophy, faHeart, faBullhorn, faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons';

library.add(faEye, faEyeSlash, faRotate, faUserSlash, faLock, faXmark, faCheck, faTriangleExclamation, faFile, faHouse, faTrash, faBars, faBan, faPlug, faSteam, faAngleUp, faAngleDown, faRightFromBracket, faGear, faUser, faRightToBracket, faDiscord, faTrophy, faHeart, faBullhorn, faArrowUpRightFromSquare);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(LaravelPermissionToVueJS)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
