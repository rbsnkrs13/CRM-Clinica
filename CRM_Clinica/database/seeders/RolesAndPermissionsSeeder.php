<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache'); //limpia cache para que se implementen bien en la bbdd

        Permission::create(['name' => 'view patients']);
        Permission::create(['name' => 'create patients']);
        Permission::create(['name' => 'edit patients']);
        Permission::create(['name' => 'delete patients']);

        // Permisos para la gestión de citas
        Permission::create(['name' => 'view appointments']);
        Permission::create(['name' => 'create appointments']);
        Permission::create(['name' => 'edit appointments']);
        Permission::create(['name' => 'delete appointments']);

        // Permisos para la gestión de profesionales
        Permission::create(['name' => 'view professionals']);
        Permission::create(['name' => 'create professionals']);
        Permission::create(['name' => 'edit professionals']);
        Permission::create(['name' => 'delete professionals']);

        // Permisos para la gestión de servicios
        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'create services']);
        Permission::create(['name' => 'edit services']);
        Permission::create(['name' => 'delete services']);

        // Permisos para la gestión de usuarios
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Permisos para la gestión de roles
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        // Otros permisos (puedes añadir los que necesites)
        Permission::create(['name' => 'view billing']);
        Permission::create(['name' => 'create billing']);
        Permission::create(['name' => 'view assessments']);
       
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Asignar todos los permisos al administrador

         // Rol de Profesional
         $professionalRole = Role::create(['name' => 'professional']);
         $professionalRole->givePermissionTo([
             'view patients',
             'create patients',
             'edit patients',
             'view appointments',
             'create appointments',
             'edit appointments',
             'view services',
             'view assessments',
         ]);
 
         // Rol de Recepcionista
         $receptionistRole = Role::create(['name' => 'receptionist']);
         $receptionistRole->givePermissionTo([
             'view patients',
             'create patients',
             'edit patients',
             'view appointments',
             'create appointments',
             'edit appointments',
             'view billing',
         ]);
    }
}
