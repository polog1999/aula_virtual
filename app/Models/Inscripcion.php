<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = "inscripciones";
    // protected $fillable = [
    //     'seccion_id'
    // ];
    protected $guarded = [];

    public function seccion(){
        return $this->belongsTo(Seccion::class,'seccion_id');
    }
    public function ordenAlumno(){
        return $this->belongsTo(InscripcionAlumno::class,'inscripcion_alumno_id');
    }
    public function ordenApoderado(){
        return $this->belongsTo(InscripcionApoderado::class,'inscripcion_apoderado_id');
    }
}
