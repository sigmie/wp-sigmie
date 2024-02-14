import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import prefixer from 'postcss-prefix-selector';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';
import safeImportant from 'postcss-safe-important';

// https://vitejs.dev/config/
export default defineConfig({
  css: {
    postcss: {
      plugins: [
        tailwindcss,
        autoprefixer,
        safeImportant(
          {
            excludeSelectors: (selector) => {
              return !selector.startsWith('.p-');
            }
          },
        ),
        prefixer({
          prefix: '#sigmie-filters',
          transform(prefix, selector, prefixedSelector, filePath, rule) {
            if (selector.startsWith('@') || selector.includes('box-sizing')) {
              return selector;
            }
            return prefixedSelector;
          },
        }),
      ],
    }
  },
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
    {
      config() {
        return { define: { __VUE_PROD_DEVTOOLS__: process.env.NODE_ENV === 'production' } }
      },
    },
  ],
  server: {
    host: '127.0.0.1'
  },
  build: {
    emptyOutDir: false,
    outDir: 'public',
    rollupOptions: {
      input: {
        main: 'resources/main.js',
      },
      output: {
        entryFileNames: 'assets/sigmie-public.js',
        chunkFileNames: 'assets/sigmie-public.js',
        assetFileNames: 'assets/sigmie-public.[ext]'
      },
    },
  },
})
