<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'correo',
        'contraseña',
        'rol_id',
    ];

    protected $hidden = [
        'contraseña',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}