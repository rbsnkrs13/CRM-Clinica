<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <nav class="admin-navigation">
    <ul>
      <li>
        <Link href="/admin/dashboard">Dashboard</Link>
      </li>

      <li class="submenu-container">
        <span class="submenu-toggle">Usuarios</span>
        <ul class="submenu">
          <li><Link href="/admin/users">Ver todos</Link></li>
          <li><Link href="/admin/professionals">Ver profesionales</Link></li>
          <li><Link href="/admin/users/create">Crear nuevo usuario</Link></li>
        </ul>
      </li>
      <li class="submenu-container">
        <span class="submenu-toggle">Pacientes</span>
        <ul class="submenu">
          <li><Link href="/admin/patients/search">Buscar un paciente</Link></li>
          <li><Link href="/admin/patients">Ver todos los pacientes</Link></li>
          <li><Link href="/admin/patients/create">Crear nuevo paciente</Link></li>
        </ul>
      </li>
      <li class="submenu-container">
        <span class="submenu-toggle">Calendario</span>
        <ul class="submenu">
          <li><Link href="/admin/calendar/my-appointments">Mis citas</Link></li>
          <li><Link href="/admin/calendar/professionals">Ver calendario</Link></li>
        </ul>
      </li>
      <li>
        <Link href="/admin/schools">Colegios</Link>
      </li>
      <li>
        <Link href="/admin/trainings">Formaciones</Link>
      </li>
    </ul>
  </nav>
</template>
<style scoped>
.admin-navigation ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-navigation li {
    padding: 14px 15px; /* Espaciado un poco mayor */
    position: relative;
    border-bottom: 1px solid #3f5a6b; /* Línea separadora entre los enlaces */
    margin-bottom: 6px; /* Más espacio entre los enlaces */
}

.admin-navigation li:last-child {
    border-bottom: none;
}

.admin-navigation a,
.admin-navigation .submenu-toggle {
    text-decoration: none;
    color: white;
    display: block;
    cursor: pointer;
    font-weight: 500;
}

.admin-navigation a:hover {
    color: #007bff; /* Azul más fuerte al pasar el ratón */
}

/* Submenú lateral */
.submenu-container {
    position: relative;
}

.submenu {
    display: none;
    position: absolute;
    top: 0;
    left: 100%;
    background-color: #4f748c;
    min-width: 200px;
    z-index: 1000;
    padding: 0;
    margin: 0;
}

.submenu li {
    padding: 10px;
    border-bottom: 1px solid #3f5a6b;
    color: #3f5a6b;
}

.submenu li:last-child {
    border-bottom: none;
}

/* Hover sobre los elementos del submenú */
.submenu li a:hover {
    color: #003366; /* Azul marino oscuro para el texto en el submenú */
}

.submenu-container:hover .submenu-toggle {
    color: #007bff;
}

.submenu-container:hover .submenu {
    display: block;
}

</style>