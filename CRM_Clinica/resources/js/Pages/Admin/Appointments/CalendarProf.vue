<template>
    <div>
      <FullCalendar
        ref="calendarRef"
        :options="calendarOptions"
      />
  
      <!-- Modal de nueva cita -->
      <Modal v-if="showModal" @close="closeModal">
        <AppointmentForm
          :selectedDate="selectedDate"
          :professionalId="professionalId"
          @saved="handleAppointmentSaved"
        />
      </Modal>
  
      <!-- Menú contextual -->
      <ContextMenu
        v-if="contextMenu.visible"
        :x="contextMenu.x"
        :y="contextMenu.y"
        @new-appointment="openModal(contextMenu.date)"
        @delete-appointment="deleteAppointment(contextMenu.appointmentId)"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, reactive } from 'vue'
  import FullCalendar from '@fullcalendar/vue3'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import Modal from '@/Components/Modal.vue'
  import AppointmentForm from '@/Pages/Admin/Appointments/AppointmentForm.vue'
  import ContextMenu from '@/Components/Calendar/ContextMenu.vue'
  import { router } from '@inertiajs/vue3'
  
  const calendarRef = ref(null)
  const showModal = ref(false)
  const selectedDate = ref(null)
  const professionalId = ref($page.props.auth.user.professional.id)
  
  const contextMenu = reactive({
    visible: false,
    x: 0,
    y: 0,
    date: null,
    appointmentId: null,
  })
  
  const appointments = ref([])
  
  const fetchAppointments = async () => {
    // Aquí haces un fetch a tu backend para las citas de este profesional
    appointments.value = await fetch(`/api/professionals/${professionalId.value}/appointments`).then(res => res.json())
  }
  
  const calendarOptions = {
    plugins: [timeGridPlugin, interactionPlugin],
    initialView: 'timeGridWeek',
    events: appointments,
    allDaySlot: false,
    slotMinTime: '08:00:00',
    slotMaxTime: '20:00:00',
    editable: false,
    selectable: true,
    height: 'auto',
    firstDay: 1,
    eventClick(info) {
      contextMenu.visible = true
      contextMenu.x = info.jsEvent.pageX
      contextMenu.y = info.jsEvent.pageY
      contextMenu.appointmentId = info.event.id
    },
    dateClick(info) {
      contextMenu.visible = true
      contextMenu.x = info.jsEvent.pageX
      contextMenu.y = info.jsEvent.pageY
      contextMenu.date = info.dateStr
    },
  }
  
  const openModal = (date) => {
    selectedDate.value = date
    showModal.value = true
    contextMenu.visible = false
  }
  
  const closeModal = () => {
    showModal.value = false
    selectedDate.value = null
  }
  
  const handleAppointmentSaved = () => {
    closeModal()
    fetchAppointments()
  }
  
  const deleteAppointment = async (id) => {
    await router.delete(`/admin/appointments/${id}`)
    fetchAppointments()
    contextMenu.visible = false
  }
  
  // Inicializar citas
  fetchAppointments()
  </script>
  