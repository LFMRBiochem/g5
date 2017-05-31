<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;

class nmn_cat_tipo_contrato extends Model
{
    protected $table = 'nmn_cat_tipo_contrato';
    public $fillable = ['cve_tipoContrato',
        'cve_compania',
        'descripcion_modelo',
        'cve_regimen',
        'percepcion_deduccion',
        'cve_origenRecurso',
        'cve_tipoJornada',
        'id_tipo_nomina',
        'estatus',];
    public $incrementing = true;
    public $timestamps = false;
    public $primaryKey = 'id_modelo_contrato';

    

}
