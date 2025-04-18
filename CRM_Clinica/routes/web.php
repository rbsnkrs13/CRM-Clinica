<?php

use Inertia\Inertia;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->get('/', function () {
    return redirect()->route('admin.dashboard'); // O donde quieras redirigir si el usuario está logueado
});

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

Route::get('/test-calendar', function () {
    return Inertia::render('TestCalendar');
});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard'); // muestra el dashboard del admin

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');          // muestra la lista de usuarios
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');       // muestra el formulario para crear un usuario
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');          // crea un nuevo usuario
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');          // muestra los detalles de un usuario (opcional)
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');         // muestra el formulario para editar un usuario
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');       // update un usuario
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');    // elimina un usuario
    Route::put('/users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore'); // restaura un usuario eliminado

    Route::get('/professionals', [UserController::class, 'professional'])->name('admin.users.professional'); // muestra la lista de profesionales
    Route::get('/professionals/{professional}/edit', [UserController::class, 'editProfessional'])->name('admin.users.editProfessional'); // muestra el formulario para editar un profesional
    Route::put('/professionals/{professional}', [UserController::class, 'updateProfessional'])->name('admin.users.updateProfessional'); // update un profesional
    Route::get('/professionals/{professional}/show', [UserController::class, 'showProfessional2'])->name('admin.users.showProfessional2'); // muestra los detalles de un profesional (opcional)

    Route::get('/patients', [PatientController::class, 'index'])->name('admin.patients.index'); // muestra la lista de pacientes
    Route::get('/patients/{patient}/show', [PatientController::class, 'show'])->name('admin.patients.show'); // muestra los detalles de un paciente (opcional)
    Route::get('/patients/create', [PatientController::class, 'create'])->name('admin.patients.create'); // muestra el formulario para crear un paciente
    Route::post('/patients/store', [PatientController::class, 'store'])->name('admin.patients.store'); // crea un nuevo paciente
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients.edit'); // muestra el formulario para editar un paciente
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients.update'); // update un paciente
    Route::post('/patients/{patient}/upload-medical-history', [PatientController::class, 'uploadMedicalHistory']);
    Route::get('/patients/search', [PatientController::class, 'searchPatient'])->name('admin.patients.search'); // busca un paciente
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy'); // elimina un paciente

    Route::get('/calendar', [AppointmentController::class, 'showCalendar'])->name('admin.calendar'); // muestra el calendario de citas
    Route::get('/appointments/{professionalId}', [AppointmentController::class, 'getAppointmentsByProfessional'])->name('admin.getAppointmentsByProfessional');
    Route::get('/calendar/professionals', [AppointmentController::class, 'professional'])->name('admin.calendar');
    Route::get('/calendar/my-appointments', [AppointmentController::class, 'myAppointments'])->name('admin.myAppointments'); // muestra las citas del profesional autenticado
    Route::post('/calendar/store', [AppointmentController::class, 'store'])->name('admin.calendar.store'); // crea una nueva cita
    Route::get('/calendar/appointments/{id}', [AppointmentController::class, 'show'])->name('admin.calendar.show'); // muestra los detalles de una cita
    Route::delete('/calendar/delete/{id}', [AppointmentController::class, 'destroy'])->name('admin.calendar.destroy'); // elimina una cita
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
