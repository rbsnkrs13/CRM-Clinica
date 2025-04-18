<script>
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
  components: {
    FullCalendar
  },
  layout: AdminLayout,
  props: {
    appointments: Array,
    patients: Array,  // se espera que los pacientes sean pasados como prop
    services: Array   // se espera que los servicios sean pasados como prop
  },
  data() {
    return {
      calendarOptions: {
      plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
      initialView: 'timeGridWeek',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      weekends: true,
      scrollTime: '10:00:00',
      slotMinTime: '10:00:00',
      slotMaxTime: '21:00:00',
      slotDuration: '00:30:00',
      slotLabelFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      height: 'auto',
      editable: true,
      selectable: true,
      selectMirror: true,
      events: this.formatAppointments(this.appointments),
      eventContent: this.eventContent,
      select: this.handleDateSelect,
      eventClick: this.handleEventClick,
      eventDrop: this.handleEventDrop,
      eventResize: this.handleEventResize,
      eventDidMount: this.eventDidMount  
    },
      contextMenuVisible: false,
      contextMenuPosition: { top: '0px', left: '0px' },
      selectedAppointmentId: null,
      showCreateForm: false,
      professional_id: this.$page.props.auth.user.id,
      newAppointment: {
        patient_name: '',  // combinamos nombre y apellido en este campo
        service_id: '',
        professional_id: this.$page.props.auth.user.id, // coge el id del user logueado
        start_time: '',
        end_time: '',
        status: 'scheduled',  //  valor predeterminado
        notes: '',
        reason: ''
      },
      selectedDate: null
    };
  },
  mounted() {
    this.addRightClickListener();
  },
  beforeUnmount() {
    this.removeRightClickListener();
  },
  methods: {
    formatAppointments(appointments) {
      return appointments.map(appointment => ({
        id: String(appointment.id), // aseguramos que sea string
        title: appointment.service.name,
        start: appointment.start_time,
        end: appointment.end_time,
        allDay: false,
        extendedProps: {
          patientName: `${appointment.patient.name} ${appointment.patient.lastName}`,
          professionalName: appointment.professional.name
        }
      }));
    },
    eventDidMount(info) { //para que pueda coger el id de la cita cuando clikamos derecho
      info.el.setAttribute('data-event-id', info.event.id);
    },
    eventContent(arg) {
      const patientName = arg.event.extendedProps.patientName;
      const serviceName = arg.event.title;
      return {
        html: `<div style="font-size: 0.75rem"><strong>${patientName}</strong><br>${serviceName}</div>`
      };
    },
    handleDateSelect(selectInfo) {
      this.selectedDate = selectInfo;
      this.showCreateForm = true;
    },
    handleEventClick(clickInfo) {
      const appointmentId = clickInfo.event.id;
      this.$inertia.get(`/admin/calendar/appointments/${appointmentId}`);
    },
    handleEventDrop(dropInfo) {
      console.log(dropInfo.event.startStr, dropInfo.event.endStr);
    },
    handleEventResize(resizeInfo) {
      console.log(resizeInfo.event.startStr, resizeInfo.event.endStr);
    },
    createEventId() {
      return String(Math.random().toString(36).substr(2, 9));
    },
    addRightClickListener() {
      const calendarEl = this.$refs.fullCalendar.$el;
      calendarEl.addEventListener('contextmenu', this.handleRightClick, false);
    },
    removeRightClickListener() {
      const calendarEl = this.$refs.fullCalendar?.$el;
      if (calendarEl) {
        calendarEl.removeEventListener('contextmenu', this.handleRightClick, false);
      }
    },
    handleRightClick(event) {
      event.preventDefault();

      const calendarApi = this.$refs.fullCalendar.getApi();
      const allEvents = calendarApi.getEvents();

      const target = event.target.closest('.fc-event');

      if (target) {         //obtiene el id
        const eventId = target.getAttribute('data-event-id');
        const clickedEvent = allEvents.find(ev => ev.id === eventId);

        if (clickedEvent) {
          this.selectedAppointmentId = clickedEvent.id;

          this.contextMenuPosition = { //para que cuando clikemos salga exactamente donde hemos clikado el menu
            top: `${event.clientY}px`,
            left: `${event.clientX}px`
          };

          this.contextMenuVisible = true;
        }
      } else {
        this.contextMenuVisible = false;
      }
    },
    confirmDelete() {
      if (!this.selectedAppointmentId) return;

      this.$inertia.delete(`/admin/calendar/delete/${this.selectedAppointmentId}`, {
        preserveScroll: true,
        onSuccess: () => {
          const calendarApi = this.$refs.fullCalendar.getApi();
          const event = calendarApi.getEventById(this.selectedAppointmentId);
          if (event) event.remove();

          this.contextMenuVisible = false;
          this.selectedAppointmentId = null;
        },
        onError: () => {
          alert('Error al eliminar la cita');
        }
      });
    },
    closeContextMenu() {
      this.contextMenuVisible = false;
    },
    async submitAppointment() {
    console.log('submitAppointment called');

    const startDate = this.selectedDate.startStr.slice(0, 19).replace('T', ' ');
    const endDate = this.selectedDate.endStr.slice(0, 19).replace('T', ' ');

    const appointmentData = {
      ...this.newAppointment,
      professional_id: this.professional_id,
      start_time: startDate,
      end_time: endDate
    };

    try {
      console.log('Sending data:', appointmentData);
      await this.$inertia.post('/admin/calendar/store', appointmentData);

      const calendarApi = this.$refs.fullCalendar.getApi();

      const newEvent = {
        id: String(Math.random().toString(36).substr(2, 9)),
        title: this.newAppointment.service_id,
        start: startDate,
        end: endDate,
        allDay: false,
        extendedProps: {
          patientName: this.newAppointment.patient_name,
          professionalName: this.$page.props.auth.user.name
        }
      };

      calendarApi.addEvent(newEvent);
      this.showCreateForm = false;
      this.selectedDate = null;
      console.log('Appointment created successfully');
    } catch (error) {
      console.error('Error creating appointment:', error);
      alert('Error al crear la cita');
    }
  },
    cancelCreateForm() {
      this.showCreateForm = false;
      this.selectedDate = null;
    }
  }
};
</script>

<template>
  <div class="calendar-container relative" @click="closeContextMenu">
    <FullCalendar :options="calendarOptions" ref="fullCalendar" />

    <div
      v-if="contextMenuVisible"
      :style="contextMenuPosition"
      class="fixed bg-white border border-gray-300 rounded-md shadow-md z-50"
    >
      <ul class="py-2">
        <li @click="confirmDelete" class="px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer">Eliminar cita</li>
        <li @click="closeContextMenu" class="px-4 py-2 text-gray-700 hover:bg-gray-100 cursor-pointer">Cancelar</li>
      </ul>
    </div>

    <!-- Formulario para crear cita -->
    <div v-if="showCreateForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-lg font-bold mb-4">Crear Nueva Cita</h3>

        <form @submit.prevent="submitAppointment">
          <!-- Nombre completo del paciente -->
          <div class="mb-4">
            <label for="patient_name" class="block text-sm font-semibold mb-1">Nombre del paciente</label>
            <input v-model="newAppointment.patient_name" type="text" id="patient_name" class="w-full px-4 py-2 border rounded-md" required placeholder="Ej. Juan Pérez" />
          </div>

          <!-- Servicio -->
          <div class="mb-4">
            <label for="service" class="block text-sm font-semibold mb-1">Servicio</label>
            <select v-model="newAppointment.service_id" id="service" class="w-full px-4 py-2 border rounded-md" required>
                <option value="1">Atención temprana y estimulación</option>
                <option value="2">Logopedia</option>
                <option value="3">Terapia ocupacional</option>
                <option value="4">Neuropsicología</option>
                <option value="5">Psicología</option>
                <option value="6">Fisioterapia</option>
                <option value="7">Integración sensorial</option>
                <option value="8">Alimentación</option>
                <option value="9">Terapia acuática</option>
                <option value="10">Nutrición y dietética</option>
                <option value="11">Terapias online</option>
            </select>
        </div>

          <!-- Hora de inicio -->
          <!-- <div class="mb-4">
            <label for="start_time" class="block text-sm font-semibold mb-1">Hora de inicio</label>
            <input v-model="newAppointment.start_time" type="datetime-local" id="start_time" class="w-full px-4 py-2 border rounded-md" required />
          </div>

          Hora de fin
          <div class="mb-4">
            <label for="end_time" class="block text-sm font-semibold mb-1">Hora de fin</label>
            <input v-model="newAppointment.end_time" type="datetime-local" id="end_time" class="w-full px-4 py-2 border rounded-md" required />
          </div> -->

          <!-- Estado -->
          <div class="mb-4">
            <label for="status" class="block text-sm font-semibold mb-1">Estado</label>
            <select v-model="newAppointment.status" id="status" class="w-full px-4 py-2 border rounded-md">
              <option value="scheduled">Scheduled</option>
              <option value="confirmed">Confirmed</option>
              <option value="cancelled">Rescheduled</option>
            </select>
          </div>

          <!-- Notas -->
          <div class="mb-4">
            <label for="notes" class="block text-sm font-semibold mb-1">Notas</label>
            <textarea v-model="newAppointment.notes" id="notes" class="w-full px-4 py-2 border rounded-md"></textarea>
          </div>

          <!-- Motivo -->
          <div class="mb-4">
            <label for="reason" class="block text-sm font-semibold mb-1">Motivo</label>
            <textarea v-model="newAppointment.reason" id="reason" class="w-full px-4 py-2 border rounded-md"></textarea>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="cancelCreateForm" class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Crear Cita</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.calendar-container {
  max-height: 800px;
  overflow-y: auto;
}
</style>
