<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Muestra las citas del profesional autenticado.
     */
    public function myAppointments()
    {
        $user = Auth::user();

        $appointments = $user->appointments()
            ->with(['patient', 'service','professional']) // incluye datos relacionados
            ->orderBy('start_time')
            ->get();

        return inertia('Admin/Appointments/Calendar', [
            'appointments' => $appointments,
        ]);
    }

    public function showCalendar()
    {
        $patients = Patient::all(); 
        $services = Service::all(); 

        return Inertia::render('Admin/Appointments/Calendar', [
            'patients' => $patients,
            'services' => $services
        ]);
    }

    public function store(Request $request) //func de creacion de citas
    {
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'professional_id' => 'required|exists:professionals,id',
            'service_id' => 'exists:services,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        try {
            $patient = Patient::whereRaw("CONCAT_WS(' ', name, lastName) LIKE ?", ["%{$validated['patient_name']}%"])->first(); //intenta encontrar paciente con nombre 

            if (!$patient) { //por nombre y apellido
                $patient = Patient::where('name', 'like', "%{$validated['patient_name']}%")
                                ->orWhere('lastName', 'like', "%{$validated['patient_name']}%")
                                ->first();
            }

            if (!$patient) {
                $patient = Patient::where('name', 'like', "%{$validated['patient_name']}%")->first();
            }

            if (!$patient) {
                return response()->json(['error' => 'Paciente no encontrado. Verifique que el nombre esté escrito correctamente.'], 404);
            }

            $professional = Auth::user();

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'professional_id' => $professional->id,
                'service_id' => $validated['service_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => $validated['status'] ?? 'pending',
                'notes' => $validated['notes'],
                'reason' => $validated['reason'],
            ]);

            return redirect()->route('admin.myAppointments')->with('success', 'Cita creada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) { // captura de excepciones de base de datos
            if ($e->getCode() == '42S22') {
                return response()->json(['error' => 'Error en la base de datos: columna no encontrada.'], 500);
            }

            return response()->json(['error' => 'Hubo un error en la creación de la cita.'], 500);
        }
    }


    public function show($id) //muestra una cita
    {
        $appointment = Appointment::with(['patient', 'professional.user', 'service'])
            ->findOrFail($id);

        return inertia('Admin/Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.myAppointments')->with('success', 'Cita eliminada correctamente.');
    }

    public function getAppointmentsByProfessional($professionalId) //func para obtener citas por profesional para admin
    {
        $appointments = Appointment::where('professional_id', $professionalId)
            ->with(['patient', 'service'])  
            ->get();

        $appointmentsFormatted = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->service->name,
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'patient_name' => $appointment->patient->name . ' ' . $appointment->patient->last_name,
                'professional_name' => $appointment->professional->user->name, 
            ];
        });

        return response()->json($appointmentsFormatted);
    }

    public function professional()
    {
        $professionals = Professional::with('user')->get();

        $appointments = $this->getAppointmentsByProfessional($professionals->first()->id);

        return Inertia::render('Admin/Appointments/CalendarProf', [
            'professionals' => $professionals,
            'appointments' => $appointments // pasa las citas a Vue
        ]);
    }
}
