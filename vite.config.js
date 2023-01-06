import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/custom.scss',
                'resources/sass/auth.scss',
                'resources/sass/portal.scss',

                'resources/js/app.js',
                'resources/js/portal.js',
            ],
            refresh: true,
        }),
    ],
});
