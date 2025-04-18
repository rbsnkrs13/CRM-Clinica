<?php

namespace Database\Seeders;

use App\Models\User; 
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser1 = User::create([
            'name' => 'CEO',
            'lastName' => 'MILLONES',
            'email' => 'ceomillones@example.com',
            'email_verified_at' => now(), // Marca el correo como verificado
            'password' => Hash::make('12345678'), 
            'role' => 'admin', // Asigna el rol 'admin' al usuario
        ]);

        $adminRole = Role::where('name', 'admin')->first(); //obtiene el rol de la bbdd
        $adminUser1->assignRole($adminRole); //se lo asigna en la tabla de spatie

        $adminUser2 = User::create([
            'name' => 'Manolo',
            'lastName' => 'El bombas',
            'email' => 'elbombas@example.com',
            'email_verified_at' => now(), 
            'password' => Hash::make('12345678'),
            'role' => 'admin', 
        ]);

        $adminUser2->assignRole($adminRole);    
    }
}
