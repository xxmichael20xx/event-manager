import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/custom.scss',
                'resources/sass/material.scss',
                'resources/sass/auth.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
