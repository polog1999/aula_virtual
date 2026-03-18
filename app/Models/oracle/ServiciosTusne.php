<?php

namespace App\Models\oracle;

use Illuminate\Database\Eloquent\Model;

class ServiciosTusne extends Model
{
    protected $connection = 'oracle';
    protected $table = 'SMACONCEPTOD';
    protected $primaryKey = 'CONCODIGO';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // En el modelo Distrito
public function getCondescriptAttribute($value)
{
    return trim($value);
}
}
