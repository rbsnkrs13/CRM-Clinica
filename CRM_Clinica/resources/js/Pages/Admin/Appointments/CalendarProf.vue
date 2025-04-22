<script>
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
  components: {
    FullCalendar,
  },
  layout: AdminLayout,
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        weekends: true,
        scrollTime: '10:00:00',
        slotMinTime: '10:00:00',
        slotMaxTime: '21:00:00',
        slotDuration: '00:30:00',
        slotLabelFormat: {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false,
        },
        height: 'auto',
        editable: false,
        selectable: false,
        events: [], // Sin eventos por ahora
      },
    };
  },
};
</script>

<template>
  <div class="calendar-container p-4">
    <FullCalendar :options="calendarOptions" />
  </div>
</template>

<style scoped>
.calendar-container {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
