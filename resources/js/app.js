import '../css/app.css';
import './bootstrap';

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue/dist/vue.esm-bundler.js';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

/**
 * Font Awesome
 */
import { config } from '@fortawesome/fontawesome-svg-core';
import '@fortawesome/fontawesome-svg-core/styles.css';

// Prevent FA from dynamically adding its css since we did it manually above
config.autoAddCss = false;

createInertiaApp({
  title: (title) => `${title}`,
  resolve: (name) => {
    const page = resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue'),
    );

    page.then((module) => {
      module.default.layout = module.default.layout || DefaultLayout;
    });

    return page;
  },
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Link', Link)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
