import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx',
                'resources/js/itineraries.jsx',
                'resources/js/map.jsx'
            ],
            refresh: true,
        }),
        react({
            jsxRuntime: 'classic', // 👈 Forces the classic JSX transform (avoids preamble issues)
        }),
    ],
});