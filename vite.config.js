import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // Vue plugin ko import karein

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.js', // Yeh path aapke main JS file ka hona chahiye
      refresh: true,
    }),
    vue(), // Vue plugin ko yahan add karein
  ],
});
