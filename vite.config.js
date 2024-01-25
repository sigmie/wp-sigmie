import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  resolve: {
    alias: {
      '@': '/resources',
      vue: 'vue/dist/vue.esm-bundler.js'
    }
  },
  plugins: [
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  server: {
    host: '127.0.0.1'
  },
  build: {
    emptyOutDir: false,
    manifest: true,
    outDir: 'public',
    rollupOptions: {
      input: {
        main: 'resources/main.js',
      },
    },
  },
})