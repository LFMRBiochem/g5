<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Ctb_reservacfdi_impuestos extends Model {

    //
    protected $table = 'ctb_reservacfdi_impuestos';
    public $fillable = ['id_reserva', 'descripcion', 'porcentaje', 'impuesto'];
    protected $guarded = ['id_impuesto'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_impuesto';

}
