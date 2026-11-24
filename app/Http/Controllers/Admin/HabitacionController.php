<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    // Consultar todas las habitaciones
    public function index()
    {
        $habitaciones = Habitacion::with('tipoHabitacion')
            ->orderBy('numero')
            ->get();

        return response()->json($habitaciones);
    }

    // Registrar una habitación
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_tipo_habitacion' => 'required|exists:tipos_habitacion,id_tipo_habitacion',
            'numero' => 'required|string|max:10|unique:habitaciones,numero',
            'piso' => 'required|integer|min:1',
            'estado' => 'required|in:Disponible,Mantenimiento,Inactiva',
            'observaciones' => 'nullable|string'
        ]);

        $habitacion = Habitacion::create($datos);

        return response()->json([
            'success' => true,
            'message' => 'Habitación registrada correctamente.',
            'habitacion' => $habitacion
        ], 201);
    }

    // Editar una habitación
    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::findOrFail($id);

        $datos = $request->validate([
            'id_tipo_habitacion' => 'required|exists:tipos_habitacion,id_tipo_habitacion',
            'numero' => 'required|string|max:10|unique:habitaciones,numero,' . $id . ',id_habitacion',
            'piso' => 'required|integer|min:1',
            'estado' => 'required|in:Disponible,Mantenimiento,Inactiva',
            'observaciones' => 'nullable|string'
        ]);

        $habitacion->update($datos);

        return response()->json([
            'success' => true,
            'message' => 'Habitación actualizada correctamente.',
            'habitacion' => $habitacion
        ]);
    }

    // Eliminar una habitación
    public function destroy($id)
    {
        $habitacion = Habitacion::findOrFail($id);

        // Verificar si tiene asignaciones registradas
        if ($habitacion->asignaciones()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar esta habitación porque tiene asignaciones registradas.'
            ], 422);
        }

        $habitacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Habitación eliminada correctamente.'
        ]);
    }
}