/** @type {import('tailwindcss').Config} */
export default {
  // prefix: 'sigmie-tw-',
  content: [
    'resources/**/*.vue',
    'resources/Hit.vue'
  ],
  theme: {
    extend: {
    },
  },
  plugins: [
    require('@vueform/slider/tailwind'),
  ],
}

