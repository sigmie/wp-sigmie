/** @type {import('tailwindcss').Config} */
export default {
  // prefix: 'sigmie-tw-',
  // important: true,
  content: [
    'resources/**/*.vue',
  ],
  theme: {
    extend: {
    },
  },
  plugins: [
    require('@vueform/slider/tailwind'),
  ],
}

