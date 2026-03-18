<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscripcionAlumno extends Model
{
    protected $guarded = [];
    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];
}
