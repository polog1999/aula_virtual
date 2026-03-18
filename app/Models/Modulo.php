<?php

namespace App\Models;

// use App\Models\oracle\ServiciosTusne;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Modulo extends Model
{
    protected $casts = [
        'activo' => 'integer'
    ];

    protected  $table = 'modulos';

    // protected $fillable = ['nombre', 'docente_id', 'categoria_id', 'disciplina_id', 'docente', 'lugar_id', 'vacantes', 'costo_matricula', 'costo_mensualidad', 'activo'];
    protected $guarded = [];
    // protected $appends = ['dia_semana'];
    // protected $appends = ['costo_vecino', 'costo_no_vecino','frecuencia_vecino', 'frecuencia_no_vecino'];

    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class, 'categoria_id');
    // }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
    public function sesiones(){
        return $this->hasMany(Sesion::class,'modulo_id');
    }
    // public function seccion()
    // {
    //     return $this->hasMany(Seccion::class, 'taller_id', 'id');
    // }
    // public function tusnes()
    // {
    //     return $this->hasMany(CodigoTusne::class, 'taller_id', 'id');
    // }

    // public function grupoCodigoVecino()
    // {
    //     return $this->hasOne(CodigoTusne::class, 'taller_id', 'id')->where('es_vecino', true);
    // }
    // public function grupoCodigoNoVecino()
    // {
    //     return $this->hasOne(CodigoTusne::class, 'taller_id', 'id')->where('es_vecino', false);
    // }

    // public function getCostoVecinoAttribute()
    // {
    //     $tusneVecinoLocal = $this->grupoCodigoVecino;
    //     $grupo = $tusneVecinoLocal?->grupo;
    //     $codigo = $tusneVecinoLocal?->codigo;

        
    //     return ServiciosTusne::where('congrupo', $grupo)->where('concodigo', $codigo)->value('conmonto') ?? 0;
    // }
   
    // public function getCostoNoVecinoAttribute()
    // {
    //     $tusneNoVecinoLocal = $this->grupoCodigoNoVecino;
    //     $grupo = $tusneNoVecinoLocal?->grupo;
    //     $codigo = $tusneNoVecinoLocal?->codigo;

    //     return ServiciosTusne::where('congrupo', $grupo)->where('concodigo', $codigo)->value('conmonto') ?? 0;
    // }
    // public function getFrecuenciaVecinoAttribute()
    // {
    //     $tusneNoVecinoLocal = $this->tusnes()->where('es_vecino',false)->first();
    //     $grupo = $tusneNoVecinoLocal?->grupo;
    //     $codigo = $tusneNoVecinoLocal?->codigo;
    //     $descripcion = ServiciosTusne::where('congrupo', $grupo)->where('concodigo', $codigo)->value('condescrip') ?? '';
    //     $frecuencia = Str::of($descripcion)
    //         ->after('FRECUENCIA')->after('-')
    //         ->trim();
    //     return $frecuencia;
    // }
    // public function getFrecuenciaVecinoAttribute()
    // {
    //     $tusneVecinoLocal = $this->grupoCodigoVecino;
    //     $grupo = $tusneVecinoLocal?->grupo;
    //     $codigo = $tusneVecinoLocal?->codigo;

        
    //     return ServiciosTusne::where('congrupo', $grupo)->where('concodigo', $codigo)->value('condescrip') ?? 0;
    // }

    // public function lugar(){
    //     return $this->belongsTo(Lugar::class, 'lugar_id');
    // }

    // public function matricula(){
    //     return $this->hasMany(Matricula::class);
    // }

    // public function horario(){
    //     return $this->hasMany(Horario::class);
    // }
    // public function docente(){
    //     return $this->belongsTo(Docente::class,'docente_id','user_id');
    // }
    // public function sesiones(){
    //     return $this->hasMany(Sesion::class);
    // }


    // public function getDiaSemanaAttribute()
    // {
    //     if ($this->horario->isEmpty()) {
    //         return null;
    //     }
    //     // dump($this->horario->toArray());
    //     $diasHoras = $this->horario->map(function ($h) {
    //         // Día en formato corto
    //         $dia = ucfirst(Str::substr(Str::lower($h->dia_semana), 0, 3));

    //         // Convertir horas usando Carbon
    //         $inicio = Carbon::parse($h->hora_inicio)->format('g:i a');
    //         $fin = Carbon::parse($h->hora_fin)->format('g:i a');

    //         return "$dia $inicio-$fin";
    //     });

    //     return $diasHoras->implode(' - ');
    // }




    //     public function horario()
    //     {
    //         return $this->belongsTo(Horario::class, 'horario_id');
    //     }
    // }
}
