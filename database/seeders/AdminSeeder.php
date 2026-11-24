<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            'nombres' => env('ADMIN_NOMBRES'),
            'apellidos' => env('ADMIN_APELLIDOS'),
            'tipo_documento' => env('ADMIN_TIPO_DOCUMENTO'),
            'numero_documento' => env('ADMIN_DOCUMENTO'),
            'telefono' => env('ADMIN_TELEFONO'),
            'nombre_usuario' => env('ADMIN_USUARIO'),
            'correo_login' => env('ADMIN_CORREO'),
            'password' => env('ADMIN_PASSWORD'),
        ];

        foreach ($datos as $valor) {
            if (empty($valor)) {
                $this->command->warn(
                    'Administrador no creado: configura las variables ADMIN_* en .env.'
                );
                return;
            }
        }

        DB::transaction(function () use ($datos) {

            $rol = DB::table('roles')
                ->where('nombre', 'Administrador')
                ->first();

            if (!$rol) {
                throw new RuntimeException('No existe el rol Administrador.');
            }

            // Buscar persona por documento.
            $persona = DB::table('personas')
                ->where('tipo_documento', $datos['tipo_documento'])
                ->where('numero_documento', $datos['numero_documento'])
                ->first();

            // Crear persona si no existe.
            if (!$persona) {
                $idPersona = DB::table('personas')->insertGetId([
                    'nombres' => $datos['nombres'],
                    'apellidos' => $datos['apellidos'],
                    'tipo_documento' => $datos['tipo_documento'],
                    'numero_documento' => $datos['numero_documento'],
                    'telefono' => $datos['telefono'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $persona = DB::table('personas')
                    ->where('id_persona', $idPersona)
                    ->first();
            }

            // Evitar duplicar una cuenta existente.
            $usuarioExistente = DB::table('usuarios')
                ->where('nombre_usuario', $datos['nombre_usuario'])
                ->orWhere('id_persona', $persona->id_persona)
                ->orWhere('correo_login', $datos['correo_login'])
                ->exists();

            if ($usuarioExistente) {
                $this->command->warn(
                    'No se creó el administrador porque ya existe una cuenta con esos datos.'
                );
                return;
            }

            DB::table('usuarios')->insert([
                'id_persona' => $persona->id_persona,
                'id_rol' => $rol->id_rol,
                'nombre_usuario' => $datos['nombre_usuario'],
                'correo_login' => $datos['correo_login'],
                'password' => Hash::make($datos['password']),
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        $this->command->info('Proceso de administrador inicial finalizado.');
    }
}
