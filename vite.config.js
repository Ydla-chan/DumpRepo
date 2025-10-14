import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/support.js','resources/js/layout.js','resources/js/notulen.js'],
      refresh: true,
    }),
    tailwindcss(), // langsung dipanggil di Vite
  ],
})
