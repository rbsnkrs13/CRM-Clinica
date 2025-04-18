<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  patient: Object,
  schools: Array,
});

const form = useForm({
  name: props.patient?.name || '',
  lastName: props.patient?.lastName || '',
  birth_date: props.patient?.birth_date || '',
  gender: props.patient?.gender || '',
  medical_history: props.patient?.medical_history || '',
  parent1_name: props.patient?.parent1_name || '',
  parent1_lastName: props.patient?.parent1_lastName || '',
  parent1_phone: props.patient?.parent1_phone || '',
  parent1_relationship: props.patient?.parent1_relationship || '',
  parent2_name: props.patient?.parent2_name || '',
  parent2_lastName: props.patient?.parent2_lastName || '',
  parent2_phone: props.patient?.parent2_phone || '',
  parent2_relationship: props.patient?.parent2_relationship || '',
  address: props.patient?.address || '',
  phone: props.patient?.phone || '',
  email: props.patient?.email || '',
  school_id: props.patient?.school_id || '',
  medical_history_file: null,
});

const submit = () => {
  form.put(`/admin/patients/${props.patient.id}`);
};

const uploadMedicalHistory = () => { //aseguramos que se pueda manejar archivos y que haga udpate
  const fileData = new FormData();
  fileData.append('medical_history_file', form.medical_history_file);

  form.post(`/admin/patients/${props.patient.id}/upload-medical-history`, fileData, {
    preserveScroll: true,
    onSuccess: () => {
      form.medical_history_file = null;
    },
  });
};

const deletePatient = () => {
  if (confirm('¿Estás seguro de que quieres eliminar a este paciente? Esta acción no se puede deshacer.')) {
    router.delete(`/admin/patients/${props.patient.id}`);
  }
};
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Editar Paciente</h1>

      <!-- Formulario principal -->
      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.name" type="text" placeholder="Nombre" class="input" />
          <input v-model="form.lastName" type="text" placeholder="Apellido" class="input" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.birth_date" type="date" class="input" />
          <select v-model="form.gender" class="input">
            <option disabled value="">Selecciona género</option>
            <option value="male">Masculino</option>
            <option value="female">Femenino</option>
            <option value="other">Otro</option>
          </select>
        </div>

        <textarea v-model="form.medical_history" placeholder="Historial médico" class="input"></textarea>

        <h2 class="text-lg font-semibold mt-4">Información del Padre/Madre 1</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.parent1_name" type="text" placeholder="Nombre" class="input" />
          <input v-model="form.parent1_lastName" type="text" placeholder="Apellido" class="input" />
          <input v-model="form.parent1_phone" type="text" placeholder="Teléfono" class="input" />
          <input v-model="form.parent1_relationship" type="text" placeholder="Relación" class="input" />
        </div>

        <h2 class="text-lg font-semibold mt-4">Información del Padre/Madre 2</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input v-model="form.parent2_name" type="text" placeholder="Nombre" class="input" />
          <input v-model="form.parent2_lastName" type="text" placeholder="Apellido" class="input" />
          <input v-model="form.parent2_phone" type="text" placeholder="Teléfono" class="input" />
          <input v-model="form.parent2_relationship" type="text" placeholder="Relación" class="input" />
        </div>

        <input v-model="form.address" type="text" placeholder="Dirección" class="input" />
        <input v-model="form.phone" type="text" placeholder="Teléfono" class="input" />
        <input v-model="form.email" type="email" placeholder="Email" class="input" />

        <select v-model="form.school_id" class="input">
          <option disabled value="">Selecciona escuela</option>
          <option v-for="school in schools" :key="school.id" :value="school.id">
            {{ school.name }}
          </option>
        </select>

        <div class="flex justify-between gap-4 pt-4">
          <button type="submit" class="flex-1 py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-200">
            Actualizar Paciente
          </button>
          <button type="button" @click="deletePatient" class="flex-1 py-3 px-6 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200">
            Eliminar Paciente
          </button>
        </div>

        <div v-if="form.errors" class="text-red-500 mt-4">
          <div v-for="(msg, key) in form.errors" :key="key">{{ msg }}</div>
        </div>
      </form>

      <!-- Formulario solo para subir PDF -->
        <form @submit.prevent="uploadMedicalHistory" enctype="multipart/form-data" class="space-y-4 mt-8">
            <label class="block">
                <span class="text-gray-700 text-sm font-medium">Subir nuevo historial médico (PDF)</span>
                <input
                type="file"
                accept="application/pdf"
                @change="e => form.medical_history_file = e.target.files[0]"
                class="block w-full text-sm text-gray-600 mt-2
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100 transition"
                />
            </label>

            <button
                type="submit"
                class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition"
            >
                Subir PDF
            </button>
        </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200;
}
</style>
