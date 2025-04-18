<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  roles: Array,
  services: Array,
});

const form = useForm({
  name: '',
  lastName: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: '',
  specialization: '',
  phone: '',
  availability: '',
  address: '',
  biography: '',
  services: [], // para IDs de servicios seleccionados
});

const isProfessional = computed(() => form.role === 'professional');

const submit = () => {
  form.post('/admin/users/store')
    .then(() => form.reset());
};
</script>

<template>
  <AdminLayout>
    <Head title="Crear nuevo User" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Creación de nuevo usuario
      </h2>
    </template>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md mt-8">
      <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Crear nuevo usuario profesional</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.name" type="text" placeholder="Nombre" class="input" />
          <input v-model="form.lastName" type="text" placeholder="Apellido" class="input" />
        </div>

        <input v-model="form.email" type="email" placeholder="Email" class="input" />
        <input v-model="form.password" type="password" placeholder="Contraseña" class="input" />
        <input v-model="form.password_confirmation" type="password" placeholder="Confirmar contraseña" class="input" />

        <select v-model="form.role" class="input">
          <option disabled value="">Selecciona un rol</option>
          <option value="professional">Professional</option>
          <option value="recepcionist">Recepcionist</option>
        </select>

        <!-- Selector de servicios si el rol es 'professional' -->
        <div v-if="isProfessional">
          <label class="block text-sm font-medium text-gray-700 mb-1">Servicios</label>
          <select v-model="form.services" class="input" multiple>
            <option v-for="service in services" :key="service.id" :value="service.id">
              {{ service.name }}
            </option>
          </select>
        </div>

        <input v-model="form.specialization" type="text" placeholder="Especialización" class="input" />
        <input v-model="form.phone" type="text" placeholder="Teléfono" class="input" />
        <input v-model="form.availability" type="text" placeholder="Disponibilidad" class="input" />
        <input v-model="form.address" type="text" placeholder="Dirección" class="input" />
        <textarea v-model="form.biography" placeholder="Biografía" class="input h-32 resize-none"></textarea>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg w-full">
          Crear Profesional
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
  @apply w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400;
}
</style>
