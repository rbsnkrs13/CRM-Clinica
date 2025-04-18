<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  roles: Array,
  user: Object,
})

const form = useForm({
  name: props.user ? props.user.name : '',
  lastName: props.user ? props.user.lastName : '',
  email: props.user ? props.user.email : '',
  password: '',
  password_confirmation: '',
  role: props.user && props.user.roles ? props.user.roles[0]?.name || '' : '',
})

const submit = () => {
  // Aquí pasamos directamente la URL de la ruta para actualizar el usuario
  form.put(`/admin/users/${props.user.id}`)
}
</script>

<template>
  <AdminLayout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">
        {{ props.user ? 'Editar Usuario' : 'Crear Nuevo Usuario' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.name" type="text" placeholder="Nombre" class="input" />
          <input v-model="form.lastName" type="text" placeholder="Apellido" class="input" />
        </div>

        <input v-model="form.email" type="email" placeholder="Email" class="input" />
        <input v-model="form.password" type="password" placeholder="Nueva Contraseña" class="input" />
        <input v-model="form.password_confirmation" type="password" placeholder="Confirmar Contraseña" class="input" />

        <select v-model="form.role" class="input">
          <option disabled value="">Selecciona un rol</option>
          <option v-for="role in roles" :key="role.id" :value="role.name">
            {{ role.name }}
          </option>
        </select>

        <button type="submit" class="w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-200">
          {{ props.user ? 'Actualizar Usuario' : 'Crear Usuario' }}
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
