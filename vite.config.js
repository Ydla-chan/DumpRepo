import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/support.js',
        'resources/js/layout.js',
        'resources/js/notulen.js'
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],

  // 🔥 Tambahan agar Vite bisa diakses dari device lain (port forwarding)
  server: {
    host: "0.0.0.0",  // membuka akses dari luar localhost
    port: 5173,      // port default vite
    hmr: {
      host: "localhost", // biar HMR tetap jalan
    }
  }
})
