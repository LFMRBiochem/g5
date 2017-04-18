<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Ctb_documentos_partidas extends Model
{
    //
    protected $table = 'ctb_documentos_partidas';
    public $fillable = ['total_partida','subtotal','porcentaje_descuento','porcentaje_impuesto','precio_unitario','cve_unidad_medida','	cantidad','descripcion_complementaria','id_conceptofinanciero','num_partida'];
    protected $guarded = ['folio_documento'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'folio_documento';

}
