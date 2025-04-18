<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid' // Importa el plugin de TimeGrid si quieres horas

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data: function() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin], // Añade timeGridPlugin si quieres horas
        initialView: 'timeGridWeek', // Cambia a una vista con horas
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        weekends: true,
        slotMinTime: '10:00:00', // Establece la hora de inicio de las franjas horarias
        slotMaxTime: '21:00:00', // Establece la hora de fin de las franjas horarias
        slotLabelFormat: {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false // Usa formato de 24 horas
        },
        // Puedes probar ajustando la duración del slot si el problema persiste
        // slotDuration: '00:30:00',
        events: [
          {
            title: 'Cita en Clínica',
            start: this.getTomorrowAt(9, 0),
            end: this.getTomorrowAt(10, 0),
            allDay: false
          }
        ]
      }
    };
  },
  methods: {
    getTomorrowAt(hour, minute) {
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      tomorrow.setHours(hour);
      tomorrow.setMinutes(minute);
      tomorrow.setSeconds(0);
      tomorrow.setMilliseconds(0);
      return tomorrow;
    }
  }
}
</script>

<template>
  <h1>Calendario de Citas (Prueba)</h1>
  <FullCalendar :options='calendarOptions' />
</template>