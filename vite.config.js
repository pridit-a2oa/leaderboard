import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import VueDevTools from 'vite-plugin-vue-devtools';

export default defineConfig({
  plugins: [
    tailwindcss(),
    VueDevTools({
      appendTo: 'resources/js/app.js',
    }),
    laravel({
      input: 'resources/js/app.js',
      ssr: 'resources/js/ssr.js',
      refresh: true,
    }),
    vue({
      template: {
        compilerOptions: {
          // Treat all tags with a dash as custom elements.
          isCustomElement: (tag) => tag.includes('-'),
        },
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced in Single
          // File Components, to point to the Laravel web server. Setting this
          // to `null` allows the Laravel plugin to instead re-write asset URLs
          // to point to the Vite server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them as absolute
          // paths to files on disk. Setting this to `false` will leave absolute
          // URLs un-touched so they can reference assets in the public
          // directory as expected.
          includeAbsolute: false,
        },
      },
    }),
  ],
  optimizeDeps: {
    include: ['vue'],
  },
});
