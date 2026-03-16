// vite.config.mjs
import { defineConfig } from 'vite';
import { resolve } from 'path';

const JS_FILE = resolve('assets/js/app.js');
const BUILD_DIR = resolve(__dirname, 'build/');

export default defineConfig({
  resolve: {
    alias: {
      '@': resolve(__dirname, './assets'), // ✏️ adjust to match your src folder
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@use "${resolve(__dirname, 'assets/sass/modules/mixins')}" as *;`,
      },
    },
  },
  build: {
    assetsDir: '',
    emptyOutDir: true,
    outDir: BUILD_DIR,
    rollupOptions: {
      input: JS_FILE,
      output: {
        entryFileNames: `[name].min.js`,
        chunkFileNames: `[name].min.js`,
        assetFileNames: `[name].min.css`,
      },
    },
  },
});