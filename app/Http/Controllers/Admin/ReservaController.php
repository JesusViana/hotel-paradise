<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Consultar todas las reservas
    public function index()
    {
        $reservas = Reserva::with([
            'titular',
            'tipoHabitacion'
        ])
        ->orderByDesc('id_reserva')
        ->get();

        return response()->json($reservas);
    }

    // Confirmar o cancelar una reserva
    public function actualizarEstado(Request $request, $id)
    {
        $datos = $request->validate([
            'estado' => 'required|in:Confirmada,Cancelada'
        ]);

        $reserva = Reserva::findOrFail($id);

        // Solo se pueden modificar reservas pendientes
        if ($reserva->estado !== 'Pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden modificar reservas pendientes.'
            ], 422);
        }

        $reserva->estado = $datos['estado'];
        $reserva->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado de la reserva actualizado correctamente.',
            'estado' => $reserva->estado
        ]);
    }
}