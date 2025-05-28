import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        manifest: false,
        outDir: 'public/assets', 
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                style: 'resources/css/app.css',
            },
            output: {
                entryFileNames: 'app.js',
                assetFileNames: 'app.css',
            },
        },
    },
});
