<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HabitacionSeeder extends Seeder
{
    public function run(): void
    {
        $habitaciones = [
            ['numero' => '101', 'tipo' => 'Individual', 'piso' => 1],
            ['numero' => '102', 'tipo' => 'Individual', 'piso' => 1],
            ['numero' => '103', 'tipo' => 'Doble', 'piso' => 1],
            ['numero' => '104', 'tipo' => 'Matrimonial', 'piso' => 1],

            ['numero' => '201', 'tipo' => 'Individual', 'piso' => 2],
            ['numero' => '202', 'tipo' => 'Doble', 'piso' => 2],
            ['numero' => '203', 'tipo' => 'Doble', 'piso' => 2],
            ['numero' => '204', 'tipo' => 'Matrimonial', 'piso' => 2],

            ['numero' => '301', 'tipo' => 'Doble', 'piso' => 3],
            ['numero' => '302', 'tipo' => 'Matrimonial', 'piso' => 3],
            ['numero' => '303', 'tipo' => 'Familiar', 'piso' => 3],
            ['numero' => '304', 'tipo' => 'Familiar', 'piso' => 3],
        ];

        foreach ($habitaciones as $habitacion) {

            $idTipo = DB::table('tipos_habitacion')
                ->where('nombre', $habitacion['tipo'])
                ->value('id_tipo_habitacion');

            if (!$idTipo) {
                throw new \RuntimeException(
                    "No existe el tipo de habitación: {$habitacion['tipo']}"
                );
            }

            DB::table('habitaciones')->updateOrInsert(
                ['numero' => $habitacion['numero']],
                [
                    'id_tipo_habitacion' => $idTipo,
                    'piso' => $habitacion['piso'],
                    'estado' => 'Disponible',
                    'updated_at' => now()
                ]
            );
        }
    }
}