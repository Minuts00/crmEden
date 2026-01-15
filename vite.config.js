import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/sass/app.scss',
            'resources/js/app.js',
        ]),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        // Aggiungi questa riga se vuoi forzare HTTP
        https: false,
    },
});
