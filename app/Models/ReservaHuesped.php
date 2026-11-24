<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservaHuesped extends Model
{
    protected $table = 'reserva_huespedes';

    protected $primaryKey = 'id_reserva_huesped';

    protected $fillable = [
        'id_reserva',
        'id_persona',
        'tipo_participacion',
    ];

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(
            Reserva::class,
            'id_reserva',
            'id_reserva'
        );
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(
            Persona::class,
            'id_persona',
            'id_persona'
        );
    }
}