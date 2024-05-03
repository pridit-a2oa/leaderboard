import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
        bronze: '#cd7f32',
        gold: '#d4af37',
        silver: '#c0c0c0'
      },

      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans]
      }
    },

    screens: {
      'xs': '386px',
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px'
    }
  },

  daisyui: {
    themes: [
      {
        default: {
          primary: '#0084ff',
          'base-100': '#262626',
          accent: '#ca8a04'
        }
      }
    ]
  },

  plugins: [forms, require('daisyui')]
};
