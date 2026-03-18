<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';
    protected $fillable = ['ciclo', 'anio', 'fecha_inicio','fecha_fin'];
    public $timestamps = false;
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];
}
