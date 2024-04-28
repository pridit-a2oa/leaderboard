import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue'
  ],

  theme: {
    extend: {
      colors: {
        bronze: '#7c2d12',
        gold: '#d4af37',
        silver: '#c0c0c0'
      },

      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans]
      }
    }
  },

  daisyui: {
    themes: [
      {
        default: {
          primary: '#0084ff',
          'base-100': '#262626'
        }
      }
    ]
  },

  plugins: [require('daisyui')]
};
