<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesionRecurso extends Model
{
   protected $fillable = ['sesion_id', 'nombre', 'url_path', 'tipo'];
    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
    public function recursos() {
    return $this->hasMany(SesionRecurso::class);
}
}
