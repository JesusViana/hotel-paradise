<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHabitacionSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Individual',
                'descripcion' => 'Habitación para una persona',
                'capacidad_maxima' => 1,
                'precio_base' => 150.00,
                'estado' => true
            ],
            [
                'nombre' => 'Doble',
                'descripcion' => 'Habitación para dos personas',
                'capacidad_maxima' => 2,
                'precio_base' => 220.00,
                'estado' => true
            ],
            [
                'nombre' => 'Matrimonial',
                'descripcion' => 'Habitación con cama matrimonial',
                'capacidad_maxima' => 2,
                'precio_base' => 250.00,
                'estado' => true
            ],
            [
                'nombre' => 'Familiar',
                'descripcion' => 'Habitación para familias',
                'capacidad_maxima' => 5,
                'precio_base' => 450.00,
                'estado' => true
            ]
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_habitacion')->updateOrInsert(
                ['nombre' => $tipo['nombre']],
                array_merge($tipo, [
                    'updated_at' => now()
                ])
            );
        }
    }
}