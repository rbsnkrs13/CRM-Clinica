<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  lastName: '',
  birth_date: '',
  gender: '',
  medical_history: '', 
  medical_history_file: null, // aqui guardamos el archivo PDF
  parent1_name: '',
  parent1_lastName: '',
  parent1_phone: '',
  parent1_relationship: '',
  parent2_name: '',
  parent2_lastName: '',
  parent2_phone: '',
  parent2_relationship: '',
  address: '',
  phone: '',
  email: '',
  school_id: '', // hacer select cuando tengamos coles metidos
});

const submit = () => { // aseguramos que el formulario puede manejar archivos
  form.post('/admin/patients/store', {
    onFinish: () => form.reset(), // reset del form despues de enviar
  });
};
</script>

<template>
    <AdminLayout>
      <Head title="Crear Paciente" />
  
      <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow mt-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Crear nuevo paciente</h1>
  
        <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
          <!-- Datos básicos -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input v-model="form.name" type="text" placeholder="Nombre" class="input" />
            <input v-model="form.lastName" type="text" placeholder="Apellido" class="input" />
            <input v-model="form.birth_date" type="date" placeholder="Fecha de nacimiento" class="input" />
            <select v-model="form.gender" class="input">
              <option disabled value="">Selecciona género</option>
              <option value="male">Masculino</option>
              <option value="female">Femenino</option>
              <option value="other">Otro</option>
            </select>
          </div>
  
          <!-- Historial médico (Texto) -->
          <textarea v-model="form.medical_history" placeholder="Historial médico" class="input h-32 resize-none"></textarea>
  
          <!-- Cargar historial médico (PDF) -->
          <div class="mt-4">
            <label for="medical_history_file" class="block text-sm font-semibold text-gray-700">Subir archivo PDF del historial médico</label>
            <div class="mt-2 flex items-center justify-between border border-gray-300 rounded-lg p-3 bg-white">
              <input 
                type="file" 
                id="medical_history_file"
                @change="e => form.medical_history_file = e.target.files[0]" 
                class="hidden" 
                accept="application/pdf"
              />
              <label for="medical_history_file" class="cursor-pointer text-indigo-600 hover:text-indigo-700">
                Seleccionar archivo
              </label>
              <span v-if="form.medical_history_file" class="text-sm text-gray-500 ml-4">{{ form.medical_history_file.name }}</span>
            </div>
          </div>
  
          <!-- Información de padres -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input v-model="form.parent1_name" type="text" placeholder="Nombre del primer tutor" class="input" />
            <input v-model="form.parent1_lastName" type="text" placeholder="Apellido del primer tutor" class="input" />
            <input v-model="form.parent1_phone" type="text" placeholder="Teléfono del primer tutor" class="input" />
            <input v-model="form.parent1_relationship" type="text" placeholder="Parentesco del primer tutor" class="input" />
  
            <input v-model="form.parent2_name" type="text" placeholder="Nombre del segundo tutor" class="input" />
            <input v-model="form.parent2_lastName" type="text" placeholder="Apellido del segundo tutor" class="input" />
            <input v-model="form.parent2_phone" type="text" placeholder="Teléfono del segundo tutor" class="input" />
            <input v-model="form.parent2_relationship" type="text" placeholder="Parentesco del segundo tutor" class="input" />
          </div>
  
          <!-- Contacto -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input v-model="form.phone" type="text" placeholder="Teléfono del paciente" class="input" />
            <input v-model="form.email" type="email" placeholder="Correo electrónico" class="input" />
          </div>
  
          <!-- Dirección y escuela -->
          <input v-model="form.address" type="text" placeholder="Dirección" class="input" />
          <input v-model="form.school_id" type="text" placeholder="ID del colegio" class="input" />
  
          <!-- Botón -->
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg w-full">
            Guardar paciente
          </button>
  
          <!-- Errores -->
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
  
  textarea.input {
    resize: none;
  }
  
  button {
    transition: background-color 0.3s;
  }
  
  button:hover {
    background-color: #5a67d8;
  }
  
  label[for="medical_history_file"] {
    font-weight: bold;
  }
  
  label[for="medical_history_file"]:hover {
    color: #4c51bf;
  }
  </style>
  
