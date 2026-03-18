<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    
    protected $table = 'asistencias';
    protected $fillable = ['id','matricula_id','fecha','estado', 'detalles'];
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'date'
    ];

    public function matricula(){
        return $this->belongsTo(Matricula::class,'matricula_id');
    }
}
