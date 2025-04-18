<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $services = [
            'Atención temprana y estimulación',
            'Logopedia',
            'Terapia ocupacional',
            'Neuropsicología',
            'Psicología',
            'Fisioterapia',
            'Integración sensorial',
            'Alimentación',
            'Terapia acuática',
            'Nutrición y dietética',
            'Terapias online',
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                'name' => $service,
                'description' => 'Servicio de ' . strtolower($service) . '.',
                'price' => rand(30, 80), // Precio aleatorio entre 30 y 80
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
