<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  professional: Object,
  services: Array,
});

const form = useForm({
  firstName: props.professional.user.name,  // Accedemos al nombre desde la relación
  lastName: props.professional.user.lastName,    // Accedemos al apellido desde la relación
  specialization: props.professional.specialization,
  phone: props.professional.phone,
  email: props.professional.email,
  availability: props.professional.availability,
  address: props.professional.address,
  biography: props.professional.biography,
  services: props.professional.services.map(service => service.id),
});

const submit = () => {
  form.put(`/admin/professionals/${props.professional.id}`);
};
</script>

<template>
  <AdminLayout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Editar Profesional</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Mostrar el nombre completo concatenado -->
          <input :value="`${form.firstName} ${form.lastName}`" type="text" placeholder="Nombre Completo" class="input" readonly />
        </div>

        <input v-model="form.specialization" type="text" placeholder="Especialización" class="input" />
        <input v-model="form.phone" type="text" placeholder="Teléfono" class="input" />
        <input v-model="form.email" type="email" placeholder="Email" class="input" />
        <input v-model="form.availability" type="text" placeholder="Disponibilidad" class="input" />
        <input v-model="form.address" type="text" placeholder="Dirección" class="input" />
        <textarea v-model="form.biography" placeholder="Biografía" class="input"></textarea>

        <select v-model="form.services" class="input" multiple>
          <option v-for="service in services" :key="service.id" :value="service.id">
            {{ service.name }}
          </option>
        </select>

        <button type="submit" class="w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-200">
          Actualizar Profesional
        </button>

        <div v-if="form.errors" class="text-red-500 mt-2">
          <div v-for="(msg, key) in form.errors" :key="key">{{ msg }}</div>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200;
}
</style>
