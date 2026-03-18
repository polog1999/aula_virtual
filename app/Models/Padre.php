<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $fillable = ['user_id'];
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function alumnos(){
        return $this->hasMany(Alumno::class,'padre_id','user_id');
    }
}
