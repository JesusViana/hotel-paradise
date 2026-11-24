<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Reserva;
use App\Models\ReservaHuesped;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservaController extends Controller
{
    // Mostrar formulario
    public function crear($id)
    {
        $tipoHabitacion = TipoHabitacion::where('estado', true)
            ->findOrFail($id);

        return view('public.reservas.crear', compact('tipoHabitacion'));
    }

    // Guardar solicitud de reserva
    public function guardar(Request $request, $id)
    {
        $tipoHabitacion = TipoHabitacion::where('estado', true)
            ->findOrFail($id);

        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:30',
            'numero_documento' => 'required|string|max:30',
            'telefono' => 'required|string|max:20',
            'correo_contacto' => 'nullable|email|max:150',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'cantidad_huespedes' => 'required|integer|min:1',
        ]);

        // Verificar capacidad de la categoría
        if ($datos['cantidad_huespedes'] > $tipoHabitacion->capacidad_maxima) {
            return back()
                ->withErrors([
                    'cantidad_huespedes' => 'La capacidad máxima es de '
                        . $tipoHabitacion->capacidad_maxima . ' personas.'
                ])
                ->withInput();
        }

        $reserva = DB::transaction(function () use ($datos, $tipoHabitacion) {
            // Buscar persona por documento o crear una nueva
            $persona = Persona::firstOrNew([
                'tipo_documento' => $datos['tipo_documento'],
                'numero_documento' => $datos['numero_documento'],
            ]);

            $persona->fill([
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'telefono' => $datos['telefono'],
                'correo_contacto' => $datos['correo_contacto'] ?? null,
            ]);

            $persona->save();

            // Calcular noches y precio total
            $entrada = \Carbon\Carbon::parse($datos['fecha_entrada']);
            $salida = \Carbon\Carbon::parse($datos['fecha_salida']);

            $noches = $entrada->diffInDays($salida);
            $precioNoche = $tipoHabitacion->precio_base;
            $total = $noches * $precioNoche;

            // Crear reserva
            $reserva = Reserva::create([
                'id_persona' => $persona->id_persona,
                'id_tipo_habitacion' => $tipoHabitacion->id_tipo_habitacion,
                'codigo_reserva' => 'HP-' . Str::upper(Str::random(8)),
                'fecha_entrada' => $datos['fecha_entrada'],
                'fecha_salida' => $datos['fecha_salida'],
                'cantidad_huespedes' => $datos['cantidad_huespedes'],
                'precio_noche' => $precioNoche,
                'total' => $total,
                'fecha_expiracion' => now()->addHours(3),
                'estado' => 'Pendiente',
            ]);

            // Registrar al titular como huésped
            ReservaHuesped::create([
                'id_reserva' => $reserva->id_reserva,
                'id_persona' => $persona->id_persona,
                'tipo_participacion' => 'Titular',
            ]);

            return $reserva;
        });

        return response()->json([
            'success' => true,
            'message' => 'Tu solicitud de reserva fue registrada correctamente.',
            'codigo_reserva' => $reserva->codigo_reserva,
       ]);
    }
}   
