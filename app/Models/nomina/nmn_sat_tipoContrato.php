<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;

class nmn_sat_tipoContrato extends Model
{
    protected $table = 'nmn_sat_tipoContrato';
    public $fillable = ['cve_tipoContrato', 'descripcion_tipoContrato','estatus'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'cve_tipoContrato';
}
