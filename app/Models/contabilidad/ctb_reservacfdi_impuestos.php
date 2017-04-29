<?php

namespace App\Models\contabilidad;

use Illuminate\Database\Eloquent\Model;

class ctb_reservacfdi_impuestos extends Model {

    //
    protected $table = 'ctb_reservacfdi_impuestos';
    public $fillable = ['id_reserva', 'descripcion', 'porcentaje', 'impuesto'];
    protected $guarded = ['id_impuesto'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_impuesto';

}
