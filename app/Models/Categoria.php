<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    // public $casts = ['tiene_discapacidad' => 'boolean'];
    protected $fillable = ['nombre'];
    
    public function cursos(){
    return $this->hasMany(Curso::class,'curso_id');
}
}

