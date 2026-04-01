<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    
    protected $table = 'sesiones';
    // protected $fillable = ['id','seccion_id','fecha','estado'];
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = ['fecha' => 'date'];

    // public function taller(){
    //     return $this->belongsTo(Taller::class,'taller_id','id');
    // }
    public function seccion(){
        return $this->belongsTo(Seccion::class,'seccion_id');
    }
    public function modulo(){
        return $this->belongsTo(Modulo::class,'modulo_id');
    }
    public function recursos()
{
    return $this->hasMany(SesionRecurso::class, 'sesion_id');
}
}
