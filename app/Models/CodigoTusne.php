<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoTusne extends Model
{
    protected $table = 'codigos_tusnes';
    
    protected $casts = [
        'es_vecino' => 'boolean'
    ];

    protected $fillable = [
       
        'codigo',
        'grupo',
        'taller_id',
        'es_vecino',
    ];
}
