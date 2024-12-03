import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { createPinia } from 'pinia'; // Correct Pinia import

// Ensure the app is created correctly and Pinia is added
const pinia = createPinia(); // Create Pinia instance

createInertiaApp({
    title: (title) => `${title} - ${import.meta.env.VITE_APP_NAME || 'Laravel'}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Create a new Vue app and apply Pinia before mounting it
        const app = createApp({
            render: () => h(App, props),
        });

        app.use(plugin); // Inertia plugin
        app.use(ZiggyVue); // Ziggy for route management
        app.use(pinia); // Pinia store setup

        app.mount(el); // Mount the app to the given element
    },
    progress: {
        color: '#4B5563',
    },
});
