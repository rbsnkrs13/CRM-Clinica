// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import Calendar from '@/Pages/Admin/Appointments/Calendar.vue';  // Asegúrate de que la ruta sea correcta

const routes = [
  {
    path: '/admin/calendar/my-appointments',  // Mantén la ruta que quieras usar
    name: 'MyAppointments',
    component: Calendar,  
  },
  // Puedes añadir más rutas aquí
];

const router = createRouter({
  history: createWebHistory(),
  routes, // Aquí se pasan las rutas definidas
});

export default router;
