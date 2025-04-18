<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Service;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserController extends Controller
{
    public function index(Request $request) //muestra la lista de users activos y eliminados
    {
        $user = Auth::user(); 
        $type = $request->get('type', 'active');

        if ($type === 'deleted') {
            $users = User::onlyTrashed()->get(); // solo los eliminados
        } else {
            $users = User::all(); 
        }

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'user' => $user,
            'type' => $type, // enviamos el tipo al frontend
        ]);
    }

    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function professional() //muestra la lista de professionals
    {
        $professionals = Professional::with('user')->get()->map(function ($professional) {
            return [
                'id' => $professional->id,
                'user_id' => $professional->user_id,
                'name' => $professional->user->name,      
                'lastName' => $professional->user->lastName, 
                'email' => $professional->email,
                'specialization' => $professional->specialization,
                'phone' => $professional->phone,
                'availability' => $professional->availability,
                'address' => $professional->address,
                'biography' => $professional->biography,
            ];
        });
    
        return Inertia::render('Admin/Users/Professionals', [
            'professionals' => $professionals,
        ]);
    }

    public function create() //obtiene la lista de roles para luego poder asignar al user
    {
        $roles= Role::all();
        $services = Service::all();
        return inertia('Admin/Users/Create', [
            'roles' => $roles,
            'services' => $services,
        ]);
    }
    
    public function store(Request $request) //crea tanto un user como un professional cuando se contrata a alguien
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:professional,recepcionist', // O la validación adecuada para tu tipo de role
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'availability' => 'required|string|min:8',
            'address' => 'required|string',
            'biography' => 'required|string',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,id',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        $professional = Professional::create([
            'user_id' => $user->id,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'phone' => $request->phone,
            'availability' => $request->availability,
            'address' => $request->address,
            'biography' => $request->biography,
        ]);

        if ($request->role === 'professional' && $request->has('services')) {
            $professional->services()->sync($request->services);
        }
    
        $user->assignRole($request->role); // asigna rol al user en la tabla modelhasroles
    
        return redirect()->route('admin.users.professional')->with('success', 'Professional created successfully.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return inertia('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    public function showProfessional(string $id)
    {
        $professional = Professional::findOrFail($id);
        return inertia('Admin/Users/ShowProfessional', [
            'professional' => $professional,
        ]);
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return inertia('Admin/Users/EditUsers', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|max:255', // O la validación adecuada para tu tipo de role
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->syncRoles($request->role); // asigna rol al user en la tabla modelhasroles
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function editProfessional(string $id)
    {
        $professional = Professional::with('services', 'user')->findOrFail($id); // cargamos los servicios
        $services = Service::all();
    
        return inertia('Admin/Users/EditProfessionals', [
            'professional' => $professional,
            'services' => $services,
            'selectedServices' => $professional->services->pluck('id'), // para saber cuáles tiene
        ]);
    }
    public function updateProfessional(Request $request, string $id)
    {
        $validator = $request->validate([
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professionals,email,' . $id,
            'availability' => 'required|string|min:8',
            'address' => 'required|string',
            'biography' => 'required|string',
            'services' => 'nullable|array', 
            'services.*' => 'exists:services,id',
        ]);

        $professional = Professional::findOrFail($id);
        $professional->update([
            'specialization' => $request->specialization,
            'phone' => $request->phone,
            'email' => $request->email,
            'availability' => $request->availability,
            'address' => $request->address,
            'biography' => $request->biography,
        ]);

        $professional->services()->sync($request->services ?? []);


        return redirect()->route('admin.users.professional')->with('success', 'Professional updated successfully.');
    }

    public function showProfessional2(string $id)
    {
        $professional = Professional::with('services', 'patientAssessments', 'user')->findOrFail($id); // Asegúrate de tener la relación de 'patients' si ya la has definido
        return inertia('Admin/Users/ShowProfessional', [
            'professional' => $professional,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->each(function ($role) use ($user) {
            $user->roles()->updateExistingPivot($role->id, ['deleted_at' => now()]); // Soft delete de la relación en model_has_roles
        });

        if ($user->professional) {
            $user->professional->delete();
        }

        $user->delete();
      
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        $professional = $user->professional()->withTrashed()->first(); // carga a los professionals eliminados
        if ($professional) {
            $professional->restore(); // restaurar al profsional
        }
    
        DB::table('model_has_roles')
        ->where('model_id', $user->id)
        ->where('model_type', 'App\Models\User')
        ->whereNotNull('deleted_at')
        ->update(['deleted_at' => null]); 
    
        return redirect()->route('admin.users.index')->with('success', 'User restored successfully.');
    }
}
