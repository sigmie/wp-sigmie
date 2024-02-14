/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'sgm-',
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

