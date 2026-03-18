<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $casts = [
        'fecha_pago' => 'datetime'
    ];

    protected $guarded = [];
    public function cronogramaPago(){
        return $this->belongsTo(CronogramaPago::class,'cronograma_pago_id');
    }
    public function pagosNiubiz(){
        return $this->belongsTo(PagosNiubiz::class,'pagos_niubiz_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
