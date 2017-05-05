<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class nmn_cat_conceptos extends Model
{
    //
    protected $table = 'nmn_cat_conceptos';
    public $fillable = ['id_folio_concepto',
        'cve_compania',
        'id_concepto',
        'descripcion',
        'percepcion_deduccion',
        'operacion',
        'id_conceptofinanciero',
        'considerar_recibo',
        'considerar_reportes',
        'estatus',];
    public $incrementing = true;
    public $timestamps = false;
    public $primaryKey = 'id_folio_concepto';
}
