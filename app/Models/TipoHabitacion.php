<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoHabitacion extends Model
{
    protected $table = 'tipos_habitacion';

    protected $primaryKey = 'id_tipo_habitacion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad_maxima',
        'precio_base',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'capacidad_maxima' => 'integer',
            'precio_base' => 'decimal:2',
            'estado' => 'boolean',
        ];
    }

    // Una categoría puede tener muchas habitaciones físicas.
    public function habitaciones(): HasMany
    {
        return $this->hasMany(
            Habitacion::class,
            'id_tipo_habitacion',
            'id_tipo_habitacion'
        );
    }

    // Una categoría puede estar asociada a muchas reservas.
    public function reservas(): HasMany
    {
        return $this->hasMany(
            Reserva::class,
            'id_tipo_habitacion',
            'id_tipo_habitacion'
        );
    }
}