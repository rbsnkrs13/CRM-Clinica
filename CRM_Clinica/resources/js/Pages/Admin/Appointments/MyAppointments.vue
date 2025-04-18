<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  appointments: Array
})
</script>

<template>
  <AdminLayout>
    <Head title="Mis Citas" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Citas</h2>
    </template>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div v-if="appointments.length">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Inicio</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fin</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td class="px-4 py-2">{{ appointment.patient.name }} {{ appointment.patient.lastName }}</td>
                <td class="px-4 py-2">{{ appointment.service.name }}</td>
                <td class="px-4 py-2">{{ appointment.start_time }}</td>
                <td class="px-4 py-2">{{ appointment.end_time }}</td>
                <td class="px-4 py-2">{{ appointment.status }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else class="text-gray-600 text-sm">
          No tienes citas asignadas.
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
