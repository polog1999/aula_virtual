<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronogramaPago extends Model
{
    protected $table = 'cronograma_pagos';
    
    protected $fillable = [
        'matricula_id',
        'concepto',
        'monto',
        'estado'
        ,'fecha_pago'
    ];
    protected $casts = [
        'fecha_vencimiento' => 'date'
    ];
    
    public function matricula(){
        return $this->belongsTo(Matricula::class,'matricula_id','id');
    }
    public function pago(){
        return $this->hasOne(Pago::class,'cronograma_pago_id','id');
    }
}

