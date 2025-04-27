import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
            // This ensures proper base path when deployed
            publicDirectory: 'public',
        }),
    ],
    // Use environment variable for base path, if available
    base: process.env.ASSET_URL ? process.env.ASSET_URL + '/' : '/',
});
