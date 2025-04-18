<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { computed, ref } from 'vue';

const props = defineProps({
  users: Array,
  user: Object,
  type: String,
});

const flash = computed(() => usePage().props.flash);
const selectedType = ref(props.type || 'active');

const deleteUser = (id) => { // elimina usuario (soft delete)
  if (confirm('¿Seguro que quieres eliminar este usuario?')) {
    Inertia.delete(`/admin/users/${id}`);
  }
};

const restoreUser = (id) => { // restaura usuario
  if (confirm('¿Restaurar este usuario?')) {
    Inertia.put(`/admin/users/${id}/restore`);
  }
};

const filterUsers = () => { // selector para elegir entre activos y eliminados
  Inertia.get('/admin/users', { type: selectedType.value }, { preserveState: true });
};
</script>

<template>
  <AdminLayout>
    <Head title="Lista de Usuarios" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lista de Usuarios
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

          <!-- Filtro -->
          <div class="mb-4">
            <label for="filter" class="mr-2 font-semibold">Ver usuarios:</label>
            <select id="filter" v-model="selectedType" @change="filterUsers" class="border px-2 py-1 rounded">
              <option value="active">Activos</option>
              <option value="deleted">Eliminados</option>
            </select>
          </div>

          <!-- Mensajes flash -->
          <div v-if="flash?.success" class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ flash.success }}
          </div>
          <div v-if="flash?.error" class="bg-red-100 text-red-800 p-4 rounded mb-4">
            {{ flash.error }}
          </div>

          <!-- Tabla -->
          <table class="min-w-full divide-y divide-gray-200 table-zebra">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.lastName }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.role }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <template v-if="selectedType === 'deleted'">
                    <button @click="restoreUser(user.id)" class="text-green-600 hover:text-green-900">Restaurar</button>
                  </template>
                  <template v-else>
                    <template v-if="user.role !== 'admin'">
                      <a :href="`/admin/users/${user.id}/edit`" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                      <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900 ml-8">Eliminar</button>
                    </template>
                  </template>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.table-zebra tbody tr:nth-child(odd) {
  background-color: #ffffff; /* Fila impar: blanco */
}

.table-zebra tbody tr:nth-child(even) {
  background-color: #f9fafb; /* Fila par: gris claro */
}

.table-zebra tbody tr:hover {
  background-color: #f3f4f6; /* Hover más visible */
}
</style>
