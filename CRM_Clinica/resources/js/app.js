import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';  // Importar Vue Router

// Importa tus componentes si tienes rutas específicas
import TestCalendar from './Pages/TestCalendar.vue';  // Ruta a tu componente TestCalendar

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Define las rutas usando Vue Router
const routes = [
  {
    path: '/test-calendar',
    name: 'TestCalendar',
    component: TestCalendar,
  },
  // Agrega más rutas según sea necesario
];

// Crea el router con Vue Router
const router = createRouter({
  history: createWebHistory(),
  routes, // Aquí pasas las rutas
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(router)  // Asegúrate de usar el router aquí
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
