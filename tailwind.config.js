import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme';

const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      colors: {
        'rank': {
          'bronze': '#cd7f32',
          'gold': '#d4af37',
          'silver': '#c0c0c0',
        },
        'role': {
          'supporter': '#ff5c5a',
        },
        'highlight': '#333333',
      },

      fontFamily: {
        'sans': ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },

    screens: {
      'xs': '386px',
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
    },
  },

  daisyui: {
    themes: [
      {
        default: {
          'primary': '#0084ff',
          'secondary': '#d4d4d4',
          'base-100': '#262626',
          'error': colors.red['500'],
          'success': colors.green['600'],
        },
      },
    ],
  },

  plugins: [forms, require('daisyui')],
};
