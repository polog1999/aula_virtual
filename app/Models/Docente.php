<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model   
{

    protected $table = 'docentes';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    public $casts = ['es_docente' => 'boolean'];
    public $fillable = [
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');

    }
    public function secciones(){
        return $this->hasMany(Seccion::class,'docente_id','user_id');
    }
    
}
