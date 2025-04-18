<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { professional } = usePage().props;
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-sm border border-gray-200">
      <!-- Título personalizado con nombre del profesional -->
      <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">
        Perfil laboral
      </h1>

      <!-- Datos del Profesional -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
          <p class="text-sm text-gray-500">Nombre</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.user.name }} {{ professional.user.lastName }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Télefono</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.phone }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Email</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.email }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Direccion</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.address }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Especialización</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.specialization }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Disponibilidad</p>
          <p class="text-lg font-medium text-gray-800">{{ professional.availability }}</p>
        </div>
        <div class="md:col-span-2">
          <p class="text-sm text-gray-500">Biografía</p>
          <p class="text-lg text-gray-700">{{ professional.biography }}</p>
        </div>
      </div>

      <!-- Servicios del Profesional -->
      <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Servicios Ofrecidos</h2>
        <ul class="list-disc list-inside space-y-1 text-gray-700">
          <li v-for="service in professional.services" :key="service.id">
            {{ service.name }}
          </li>
        </ul>
      </div>

      <!-- Botón para editar -->
      <div class="mt-8 text-center">
        <a
          :href="`/admin/professionals/${professional.id}/edit`"
          class="inline-block py-2 px-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition"
        >
          Editar Profesional
        </a>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
</style>
