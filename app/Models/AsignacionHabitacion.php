<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionHabitacion extends Model
{
    protected $table = 'asignaciones_habitacion';

    protected $primaryKey = 'id_asignacion';

    protected $fillable = [
        'id_reserva',
        'id_habitacion',
        'id_usuario',
        'fecha_asignacion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_asignacion' => 'datetime',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'id_reserva',
            'id_reserva'
        );
    }

    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(
            Habitacion::class,
            'id_habitacion',
            'id_habitacion'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id_usuario'
        );
    }
}