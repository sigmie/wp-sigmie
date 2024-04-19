import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from 'tailwindcss';
import safeImportant from 'postcss-safe-important';

// https://vitejs.dev/config/
export default defineConfig({
  css: {
    postcss: {
      plugins: [
        tailwindcss(),
        safeImportant(
          {
            excludeSelectors: (selector) => {
              return false;
            }
          },
        ),
      ],
    }
  },
  resolve: {
    alias: {
      '@': '/resources',
      vue: 'vue/dist/vue.esm-bundler.js'
    }
  },
  plugins: [vue()],
  server: {
    host: '127.0.0.1'
  },
  build: {
    emptyOutDir: false,
    outDir: 'admin',
    rollupOptions: {
      input: {
        main: 'resources/admin.js',
      },
      output: {
        entryFileNames: 'js/sigmie-admin.js',
        chunkFileNames: 'js/sigmie-admin.js',
        assetFileNames: 'js/sigmie-admin.[ext]'
      },
    },
  },
})

