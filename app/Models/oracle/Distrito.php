<?php

namespace App\Models\oracle;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $connection = 'oracle';
    protected $table = 'SMADISTRITO';
    protected $primaryKey = 'DISTRICODI';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // En el modelo Distrito
public function getDistridescAttribute($value)
{
    return trim($value);
}
}
