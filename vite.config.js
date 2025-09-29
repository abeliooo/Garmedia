import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', 
                'resources/js/app.js', 
                'resources/js/account.js',
                'resources/js/wishlist.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    base: '/',
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
  },
});
