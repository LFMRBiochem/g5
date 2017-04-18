<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Ctb_tipos_cambio extends Model {

    //
    protected $table = 'ctb_tipos_cambio';
    public $fillable = ['cve_moneda', 'fecha', 'tipo_cambio'];
    protected $guarded = ['id_tipo_cambio'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_tipo_cambio';

}
