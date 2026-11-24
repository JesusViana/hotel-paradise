<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Control total del sistema'
            ],
            [
                'nombre' => 'Recepcionista',
                'descripcion' => 'Administración de reservas y huéspedes'
            ],
            [
                'nombre' => 'Cliente',
                'descripcion' => 'Usuario que puede realizar reservas'
            ]
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $rol['nombre']],
                array_merge($rol, [
                    'updated_at' => now()
                ])
            );
        }
    }
}
