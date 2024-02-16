/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'sgm-',
  important: true,
  content: [
    'resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        "primary-color": "var(--primary-color)",
        "secondary-color": "var(--secondary-color)"
      }
    },
  },
  plugins: [
    require('@vueform/slider/tailwind'),
  ],
}

