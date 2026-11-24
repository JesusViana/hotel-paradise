<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\TipoHabitacion;

class HabitacionController extends Controller
{
    public function index()
    {
        $habitaciones = TipoHabitacion::where('estado', true)
            ->select(
                'id_tipo_habitacion',
                'nombre',
                'descripcion',
                'capacidad_maxima',
                'precio_base'
            )
            ->get();

        return response()->json($habitaciones);
    }
}