import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

/**
 * Font Awesome
 */
import { config } from '@fortawesome/fontawesome-svg-core';
import '@fortawesome/fontawesome-svg-core/styles.css';

// Prevent FA from dynamically adding its css since we did it manually above
config.autoAddCss = false;

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
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
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location),
        });
    },
  }),
);
