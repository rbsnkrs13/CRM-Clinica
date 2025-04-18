<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  professionals: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <AdminLayout>
    <Head title="Lista de Profesionales" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lista de Profesionales
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 table-zebra w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="professional in professionals" :key="professional.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.lastName }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.specialization }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ professional.availability }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 space-x-10">
                  <Link :href="`/admin/professionals/${professional.id}/show`" class="hover:underline">
                    Ver
                  </Link>
                  <Link :href="`/admin/professionals/${professional.id}/edit`" class="hover:underline">
                    Editar
                  </Link>
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
  background-color: #f9fafb;
}
.table-zebra tbody tr:nth-child(even) {
  background-color: #ffffff;
}
.table-zebra tbody tr:hover {
  background-color: #f3f4f6;
}
table th, table td {
  padding: 0.75rem 1.5rem;
  vertical-align: top;
}
table {
  width: 100%;
  table-layout: auto;
}
</style>
