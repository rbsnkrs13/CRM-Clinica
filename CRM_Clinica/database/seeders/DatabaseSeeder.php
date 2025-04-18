<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Service;
use App\Models\Professional;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            // Puedes añadir otros seeders aquí]);
        ]);

        $user1 = User::where('email', 'ceomillones@example.com')->first();
        $user2 = User::where('email', 'elbombas@example.com')->first();

        $prof1 = Professional::create([
            'user_id' => $user1->id,
            'specialization' => 'Neuropsicologia Clínica',
            'phone' => '123456789',
            'email' => 'ceomillones@example.com',
            'availability' => 'Lunes a Viernes, 9:00 - 17:00',
            'address' => 'Calle Falsa 123, Ciudad',
            'biography' => 'Psicólogo con más de 10 años de experiencia en terapia cognitivo-conductual.',  
            'created_at' => now(),
        ]);
        
        $prof2 = Professional::create([
            'user_id' => $user2->id,
            'specialization' => 'Neuropsicologia Clínica',
            'phone' => '123456789',
            'email' => 'elbombas@example.com',
            'availability' => 'Lunes a Viernes, 9:00 - 17:00',
            'address' => 'Calle muy falsa 123, Ciudad',
            'biography' => 'Psicóloga con más de 20 años de experiencia en terapia cognitivo-conductual.',  
            'created_at' => now(),
        ]);
        
        $services = Service::whereIn('name', [
            'Neuropsicología',
            'Psicología',
            'Terapias online'
        ])->pluck('id');
        
        $prof1->services()->sync($services);
        $prof2->services()->sync($services);
    }
}
