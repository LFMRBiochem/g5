<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;

class cmp_solicitud_pago extends Model {

    //
    protected $table = 'cbt_tipos_cambio';
    public $fillable = ['cve_moneda', 'fecha', 'tipo_cambio'];
    protected $guarded = ['id_tipo_cambio'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_tipo_cambio';

}
