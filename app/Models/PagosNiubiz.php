<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagosNiubiz extends Model
{
    protected $guarded = [];
    protected $table = 'pagos_niubiz';

    public function cronogramasPagos(){
        return $this->belongsTo(CronogramaPago::class,'cronograma_pago_id'); 
    }
    public function inscripcion(){
        return $this->belongsTo(Inscripcion::class,'inscripcion_id'); 
    }
}
