<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;

class nmn_sat_tipoJornada extends Model
{
    protected $table = 'nmn_sat_tipoJornada';
    public $fillable = ['cve_tipoJornada', 'descripcion_tipoJornada'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'cve_tipoJornada';
}
