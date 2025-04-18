<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Models\Appointment; 
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index() //func para pasar los datos a vue
    {
        $patients = Patient::with('school')->get()->map(function ($patient) {
            return [
                'id' => $patient->id,
                'name' => $patient->name,
                'lastName' => $patient->lastName,
                'birth_date' => $patient->birth_date,
                'gender' => $patient->gender,
                'medical_history' => $patient->medical_history,
                'parent1_name' => $patient->parent1_name,
                'parent1_lastName' => $patient->parent1_lastName,
                'parent1_phone' => $patient->parent1_phone,
                'parent1_relationship' => $patient->parent1_relationship,
                'parent2_name' => $patient->parent2_name,
                'parent2_lastName' => $patient->parent2_lastName,
                'parent2_phone' => $patient->parent2_phone,
                'parent2_relationship' => $patient->parent2_relationship,
                'address' => $patient->address,
                'phone' => $patient->phone,
                'email' => $patient->email,
                'school_id' => $patient->school_id,
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at,
            ];
        });

        return inertia('Admin/Patients/Index', [
            'patients' => $patients,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Patients/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:10',
            'medical_history' => 'nullable|string',
            'medical_history_file' => 'nullable|file|mimes:pdf|max:10240',
            'parent1_name' => 'nullable|string|max:255',
            'parent1_lastName' => 'nullable|string|max:255',
            'parent1_phone' => 'nullable|string|max:20',
            'parent1_relationship' => 'nullable|string|max:50',
            'parent2_name' => 'nullable|string|max:255',
            'parent2_lastName' => 'nullable|string|max:255',
            'parent2_phone' => 'nullable|string|max:20',
            'parent2_relationship' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'school_id' => 'nullable|integer', // aseguramos que school_id puede ser nulo
        ]);

        $patient = Patient::create([
            'name' => $validated['name'],
            'lastName' => $validated['lastName'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'medical_history' => $validated['medical_history'], 
            'parent1_name' => $validated['parent1_name'],
            'parent1_lastName' => $validated['parent1_lastName'],
            'parent1_phone' => $validated['parent1_phone'],
            'parent1_relationship' => $validated['parent1_relationship'],
            'parent2_name' => $validated['parent2_name'],
            'parent2_lastName' => $validated['parent2_lastName'],
            'parent2_phone' => $validated['parent2_phone'],
            'parent2_relationship' => $validated['parent2_relationship'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'school_id' => $validated['school_id'],
        ]);

        if ($request->hasFile('medical_history_file')) {
            $patient->storeMedicalHistoryFile($request->file('medical_history_file'));
        }

        return redirect()->route('admin.patients.index');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return inertia('Admin/Patients/ShowPatient', [
            'patient' => $patient,
        ]);
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);

        return inertia('Admin/Patients/Edit', [
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:10',
            'medical_history' => 'nullable|string',
            'parent1_name' => 'nullable|string|max:255',
            'parent1_lastName' => 'nullable|string|max:255',
            'parent1_phone' => 'nullable|string|max:20',
            'parent1_relationship' => 'nullable|string|max:50',
            'parent2_name' => 'nullable|string|max:255',
            'parent2_lastName' => 'nullable|string|max:255',
            'parent2_phone' => 'nullable|string|max:20',
            'parent2_relationship' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'school_id' => 'nullable|integer', 
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return redirect()->route('admin.patients.index');
    }

    public function uploadMedicalHistory(Request $request, Patient $patient)
    {
        $request->validate([
            'medical_history_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('medical_history_file')) {
            $patient->storeMedicalHistoryFile($request->file('medical_history_file'));
        }

        return back()->with('success', 'Historial médico actualizado.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients.index');
    }

    public function searchPatient(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $terms = explode(' ', $query); // divide el término de búsqueda en palabras

            $patients = Patient::where(function ($queryBuilder) use ($terms) {
                foreach ($terms as $term) {
                    $queryBuilder->where('name', 'LIKE', "%{$term}%")
                                ->orWhere('lastName', 'LIKE', "%{$term}%")
                                ->orWhere('email', 'LIKE', "%{$term}%");
                }
            })->get();
        } else {
            $patients = Patient::all(); // si no se busca nada muestra todos los pacientes
        }

        return inertia('Admin/Patients/SearchResults', [
            'patients' => $patients,
        ]);
    }

}
