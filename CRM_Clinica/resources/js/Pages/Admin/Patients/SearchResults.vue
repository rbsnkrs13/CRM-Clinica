<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  patients: Array,
});

const query = ref('');
const hasSearched = ref(false); // nuevo: saber si se ha buscado
const expandedHistories = ref({});

const toggleHistory = (id) => {
  expandedHistories.value[id] = !expandedHistories.value[id];
};

const search = () => {
  hasSearched.value = true;
  const formattedQuery = query.value.trim().toLowerCase(); // normaliza la búsqueda
  router.get('/admin/patients/search', { query: formattedQuery }, {
    preserveState: true,
    replace: true,
  });
};
</script>

<template>
  <AdminLayout>
    <Head title="Buscar Pacientes" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Buscar Paciente
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

          <!-- Buscador -->
          <form @submit.prevent="search" class="flex items-center gap-4 mb-6">
            <input
              v-model="query"
              type="text"
              placeholder="Nombre, apellido o email"
              class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
            />
            <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
            >
              Buscar
            </button>
          </form>

          <!-- Tabla de resultados -->
          <table v-if="hasSearched && patients.length" class="min-w-full divide-y divide-gray-200 table-zebra">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apellidos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Historial</th>
                <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="patient in patients" :key="patient.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ patient.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ patient.lastName }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ patient.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ patient.phone }}</td>
                <td class="px-6 py-4 text-sm text-gray-900 align-top">
                  <button
                    @click="toggleHistory(patient.id)"
                    class="text-blue-600 hover:underline text-xs mb-1"
                  >
                    {{ expandedHistories[patient.id] ? 'Mostrar menos' : 'Mostrar más' }}
                  </button>

                  <transition name="fade">
                    <div
                      v-if="expandedHistories[patient.id]"
                      class="mt-2 bg-gray-100 p-2 rounded text-xs text-gray-700"
                    >
                      {{ patient.medical_history }}
                    </div>
                  </transition>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-10 justify-end">
                  <a :href="`/admin/patients/${patient.id}/show`" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                  <a :href="`/admin/patients/${patient.id}/edit`" class="text-blue-600 hover:text-blue-900">Editar</a>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Mensaje si no hay resultados -->
          <div v-if="hasSearched && !patients.length" class="text-gray-600 mt-4">
            No se encontraron pacientes con ese criterio.
          </div>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.table-zebra tbody tr:nth-child(odd) {
  background-color: #ffffff;
}
.table-zebra tbody tr:nth-child(even) {
  background-color: #f9fafb;
}
.table-zebra tbody tr:hover {
  background-color: #f3f4f6;
}

/* Animación para mostrar/ocultar historial */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
