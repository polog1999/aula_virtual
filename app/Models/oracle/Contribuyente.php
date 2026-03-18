<?php

namespace App\Models\oracle;

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    protected $connection = 'oracle';
    protected $table = 'SMACARNOM';
    protected $primaryKey = 'MCNCONTRIB';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    // En el modelo Distrito
public function getMcncontribAttribute($value)
{
    return trim($value);
}
}
