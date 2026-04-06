<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    protected $fillable = [
        'alumno_id',
        'seccion_id',
        'fecha_matricula',
        'estado',
        'preinscripcion_id'
    ];

    // public function taller(){
    //     return $this->belongsTo(Taller::class,'taller_id');
    // }
    // public function taller(){
    //     return $this->belongsTo(Taller::class);
    // }
    public function alumnos(){
        return $this->belongsTo(Alumno::class, 'alumno_id','user_id');
    }
    public function cronogramasPagos(){
        return $this->hasMany(CronogramaPago::class,'matricula_id','id');
    }
    public function seccion(){
        return $this->belongsTo(Seccion::class,'seccion_id');
    }
    public function asistencias(){
        return $this->hasMany(Asistencia::class);
    }
    public function calificaciones(){
        return $this->hasMany(Calificacion::class);
    }
    // public function inscripcion(){
    //     return $this->belongsTo(Inscripcion::class,'inscripcion_id');
    // }
    
}

