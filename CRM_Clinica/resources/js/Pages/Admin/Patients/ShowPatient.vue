<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { patient } = usePage().props;
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-sm border border-gray-200">
      <!-- Título personalizado con nombre del paciente -->
      <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">
        Perfil del Paciente
      </h1>

      <!-- Datos del Paciente -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div v-if="patient.name && patient.lastName">
          <p class="text-sm text-gray-500">Nombre</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.name }} {{ patient.lastName }}</p>
        </div>
        <div v-if="patient.phone">
          <p class="text-sm text-gray-500">Teléfono</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.phone }}</p>
        </div>
        <div v-if="patient.email">
          <p class="text-sm text-gray-500">Email</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.email }}</p>
        </div>
        <div v-if="patient.address">
          <p class="text-sm text-gray-500">Dirección</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.address }}</p>
        </div>
        <div v-if="patient.birth_date">
          <p class="text-sm text-gray-500">Fecha de Nacimiento</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.birth_date }}</p>
        </div>
        <div v-if="patient.gender">
          <p class="text-sm text-gray-500">Género</p>
          <p class="text-lg font-medium text-gray-800">{{ patient.gender }}</p>
        </div>
      </div>

      <!-- Historial Médico -->
      <div v-if="patient.medical_history" class="mb-8">
        <p class="text-sm text-gray-500">Historial Médico</p>
        <p class="text-lg text-gray-700">{{ patient.medical_history }}</p>
      </div>

      <!-- Información de los Padres -->
      <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información de los Padres</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
          <div v-if="patient.parent1_name && patient.parent1_lastName">
            <p class="text-sm text-gray-500">Nombre Padre/Madre 1</p>
            <p class="text-lg font-medium text-gray-800">{{ patient.parent1_name }} {{ patient.parent1_lastName }}</p>
            <p class="text-sm text-gray-500">Teléfono</p>
            <p class="text-lg font-medium text-gray-800">{{ patient.parent1_phone }}</p>
            <p class="text-sm text-gray-500">Relación</p>
            <p class="text-lg font-medium text-gray-800">{{ patient.parent1_relationship }}</p>
          </div>
          <div v-if="patient.parent2_name && patient.parent2_lastName">
            <p class="text-sm text-gray-500">Nombre Padre/Madre 2</p>
            <p class="text-lg font-medium text-gray-800">{{ patient.parent2_name }} {{ patient.parent2_lastName }}</p>
            <p v-if="patient.parent2_phone" class="text-sm text-gray-500">Teléfono</p>
            <p v-if="patient.parent2_phone" class="text-lg font-medium text-gray-800">{{ patient.parent2_phone }}</p>
            <p v-if="patient.parent2_relationship" class="text-sm text-gray-500">Relación</p>
            <p v-if="patient.parent2_relationship" class="text-lg font-medium text-gray-800">{{ patient.parent2_relationship }}</p>
          </div>
        </div>
      </div>

      <!-- Botones de acción -->
      <div class="mt-8 text-center flex justify-center gap-4">
        <a
          :href="`/admin/patients/${patient.id}/edit`"
          class="inline-block py-2 px-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition"
        >
          Editar Paciente
        </a>

        <a
          v-if="patient.medical_history_file && patient.medical_history_file !== 'null'"
          :href="`/storage/${patient.medical_history_file}`"
          target="_blank"
          class="inline-block py-2 px-6 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition"
        >
          Descargar Historial Médico
        </a>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
</style>
