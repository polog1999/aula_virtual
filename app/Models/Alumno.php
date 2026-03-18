<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'padre_id',
        'codigo_estudiante'
    ];

    protected $primaryKey = 'user_id';
    
    public $incrementing = false;


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function padre(){
        return $this->belongsTo(Padre::class,'padre_id','user_id');
    }
    public function matricula(){
        return $this->hasMany(Matricula::class, 'alumno_id','user_id');
    }
    public function matriculasActivas(){
        return $this->hasMany(Matricula::class, 'alumno_id','user_id')
        ->where('estado','ACTIVA');
    }
}
