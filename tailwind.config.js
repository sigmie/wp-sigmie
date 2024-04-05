/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'sgm-',
  important: true,
  content: [
    'resources/**/*.vue',
    'admin/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        "primary-color": "var(--primary-color)",
        "secondary-color": "var(--surface-400)"
      }
    },
  },
  plugins: [
  ],
}

