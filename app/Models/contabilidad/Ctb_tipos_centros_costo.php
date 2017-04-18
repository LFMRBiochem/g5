<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Ctb_tipos_centros_costo extends Model {

    //
    protected $table = 'ctb_tipos_centros_costo';
    public $fillable = ['cve_tipoCentroCosto', 'tipo_cc'];
    protected $guarded = ['cve_tipoCentroCosto'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'cve_tipoCentroCosto';

}
