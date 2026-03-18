<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';

    protected $fillable = [
        'nombre',
        'direccion',
        'link_maps'
    ];
    public function secciones(){
        return $this->hasMany(Seccion::class,'lugar_id');
    }
}
