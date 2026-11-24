<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persona extends Model
{
    protected $table = 'personas';

    protected $primaryKey = 'id_persona';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'correo_contacto',
        'direccion',
        'fecha_nacimiento',
    ];

    // Una persona puede tener una cuenta de usuario.
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class, 'id_persona', 'id_persona');
    }

    // Una persona puede ser titular de varias reservas.
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_persona', 'id_persona');
    }

    // Una persona puede participar en varias reservas.
    public function reservasComoHuesped(): HasMany
    {
        return $this->hasMany(ReservaHuesped::class, 'id_persona', 'id_persona');
    }
}