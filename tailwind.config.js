import defaultTheme from 'tailwindcss/defaultTheme'
import typographie from '@tailwindcss/typography'
import daisyUI from 'daisyui'

/** @type {import("tailwindcss").Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [typographie, daisyUI],
  daisyui: {
    themes: [
      'light',
      'dark',
      'cupcake',
      'bumblebee',
      'emerald',
      'corporate',
      'synthwave',
      'retro',
      'cyberpunk',
      'valentine',
      'halloween',
      'garden',
      'forest',
      'aqua',
      'lofi',
      'pastel',
      'fantasy',
      'wireframe',
      'black',
      'luxury',
      'dracula',
      'cmyk',
      'autumn',
      'business',
      'acid',
      'lemonade',
      'night',
      'coffee',
      'winter',
      'dim',
      'nord',
      'sunset',
      {
        josi: {
          'primary': '#10b981',
          'secondary': '#10b981',
          'accent': '#5eead4',
          'neutral': '#0f766e',
          'base-100': '#1f2937',
          'info': '#67e8f9',
          'success': '#0891b2',
          'warning': '#7dd3fc',
          'error': '#7f1d1d',
        },
      },
    ],
  },
}
