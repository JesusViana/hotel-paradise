<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $primaryKey = 'id_habitacion';

    protected $fillable = [
        'id_tipo_habitacion',
        'numero',
        'piso',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'piso' => 'integer',
        ];
    }

    // Una habitación pertenece a una categoría.
    public function tipoHabitacion(): BelongsTo
    {
        return $this->belongsTo(
            TipoHabitacion::class,
            'id_tipo_habitacion',
            'id_tipo_habitacion'
        );
    }

    // Una habitación puede tener varias asignaciones a lo largo del tiempo.
    public function asignaciones(): HasMany
    {
        return $this->hasMany(
            AsignacionHabitacion::class,
            'id_habitacion',
            'id_habitacion'
        );
    }
}