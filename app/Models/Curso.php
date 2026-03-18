<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $guarded = [];
    protected $casts = [
        'activo' => 'integer'
    ];

    public function modulos(){
        return $this->hasMany(Modulo::class, 'curso_id');
    }
//     public function secciones()
// { 
//     return $this->hasManyThrough(Seccion::class, Modulo::class);
// }
    public function secciones()
{ 
    return $this->hasMany(Seccion::class,'curso_id');
}
  public function categoria()
{ 
    return $this->belongsTo(Categoria::class,'categoria_id');
}
}
