import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import reactRefresh from '@vitejs/plugin-react-refresh';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/about/page.js',
                'resources/js/basket/page.js',
                'resources/js/checkout/page.js',
                'resources/js/dashboard/page.js',
                'resources/js/contact/page.js',
                'resources/js/home/page.js',
                'resources/js/order/page.js',
                'resources/js/product/page.js',
                'resources/js/orders/page.js',
                'resources/js/shop/page.js',
                'resources/js/constants.js',
                'resources/js/mantine.jsx',
            ],
            refresh: true,
        }),
        reactRefresh(),
    ],
});
