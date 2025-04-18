<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  appointment: Object
})

const form = useForm({ //para poder ver los detalles de una cita
  patient_id: props.appointment.patient_id,
  professional_id: props.appointment.professional_id,
  service_id: props.appointment.service_id,
  start_time: props.appointment.start_time,
  end_time: props.appointment.end_time,
  status: props.appointment.status,
  notes: props.appointment.notes,
  reason: props.appointment.reason,
})

const goBackToCalendar = () => {
  window.location.href = '/admin/calendar/my-appointments'; // redirige a la página del calendario
}
</script>

<template>
  <AdminLayout title="Detalles de la cita">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow">
      <h1 class="text-2xl font-bold mb-6">Detalles de la cita</h1>

      <form @submit.prevent="">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Paciente -->
          <div>
            <label class="block text-sm font-medium">Paciente</label>
            <input type="text" class="input" :value="appointment.patient.name + ' ' + appointment.patient.lastName" disabled />
          </div>

          <!-- Profesional -->
          <div>
            <label class="block text-sm font-medium">Profesional</label>
            <input type="text" :value="appointment.professional.user.name + ' ' + appointment.professional.user.lastName" disabled />
          </div>

          <!-- Servicio -->
          <div>
            <label class="block text-sm font-medium">Servicio</label>
            <input type="text" class="input" :value="appointment.service.name" disabled />
          </div>

          <!-- Fecha/hora inicio -->
          <div>
            <label class="block text-sm font-medium">Inicio</label>
            <input type="datetime-local" class="input" v-model="form.start_time" disabled />
          </div>

          <!-- Fecha/hora fin -->
          <div>
            <label class="block text-sm font-medium">Fin</label>
            <input type="datetime-local" class="input" v-model="form.end_time" disabled />
          </div>

          <!-- Estado -->
          <div>
            <label class="block text-sm font-medium">Estado</label>
            <select class="input" v-model="form.status" disabled>
              <option value="scheduled" :selected="form.status === 'scheduled'">Programada</option>
              <option value="confirmed" :selected="form.status === 'confirmed'">Confirmada</option>
              <option value="cancelled" :selected="form.status === 'cancelled'">Cancelada</option>
              <option value="rescheduled" :selected="form.status === 'rescheduled'">Reprogramada</option>
            </select>
          </div>

          <!-- Motivo -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium">Motivo</label>
            <textarea class="input" rows="2" v-model="form.reason" disabled />
          </div>

          <!-- Notas -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium">Notas</label>
            <textarea class="input" rows="3" v-model="form.notes" disabled />
          </div>
        </div>

        <!-- Botón de Volver al calendario -->
        <div class="mt-6 flex justify-end">
          <button @click="goBackToCalendar" type="button" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
            Volver al calendario
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 0.375rem;
}

.bg-blue-600 {
  background-color: #3182ce;
}

.bg-blue-700 {
  background-color: #2b6cb0;
}

.transition {
  transition: background-color 0.3s ease;
}

.rounded-md {
  border-radius: 0.375rem;
}

button:hover {
  cursor: pointer;
}
</style>
