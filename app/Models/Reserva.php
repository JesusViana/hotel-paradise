<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_persona',
        'id_tipo_habitacion',
        'codigo_reserva',
        'fecha_entrada',
        'fecha_salida',
        'cantidad_huespedes',
        'precio_noche',
        'total',
        'fecha_expiracion',
        'fecha_checkin',
        'fecha_checkout',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_entrada' => 'date',
            'fecha_salida' => 'date',
            'fecha_expiracion' => 'datetime',
            'fecha_checkin' => 'datetime',
            'fecha_checkout' => 'datetime',
            'cantidad_huespedes' => 'integer',
            'precio_noche' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // La reserva pertenece a una persona titular.
    public function titular(): BelongsTo
    {
        return $this->belongsTo(
            Persona::class,
            'id_persona',
            'id_persona'
        );
    }

    // La reserva pertenece a una categoría de habitación.
    public function tipoHabitacion(): BelongsTo
    {
        return $this->belongsTo(
            TipoHabitacion::class,
            'id_tipo_habitacion',
            'id_tipo_habitacion'
        );
    }

    // Una reserva puede tener varios huéspedes.
    public function huespedes(): HasMany
    {
        return $this->hasMany(
            ReservaHuesped::class,
            'id_reserva',
            'id_reserva'
        );
    }

    // Una reserva puede tener varias asignaciones.
    public function asignaciones(): HasMany
    {
        return $this->hasMany(
            AsignacionHabitacion::class,
            'id_reserva',
            'id_reserva'
        );
    }

    // Una reserva puede tener varios pagos.
    public function pagos(): HasMany
    {
        return $this->hasMany(
            Pago::class,
            'id_reserva',
            'id_reserva'
        );
    }
}