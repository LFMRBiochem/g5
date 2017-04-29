<?php

namespace App\Models\contabilidad;

use Illuminate\Database\Eloquent\Model;

class ctb_reserva_cfdi extends Model {
    //
    protected $table = 'ctb_reserva_cfdi';
    public $fillable = ['cve_compania', 'UUID','rfc','total','nombre_proveedor','folio','subtotal','descuento','metodo_pago','cve_moneda','error_suma','descripcion','asociado'];
    protected $guarded = ['id_reserva'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_reserva';

}
