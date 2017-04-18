<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Ctb_cat_centros_costo extends Model {

    protected $table = 'ctb_cat_centros_costo';
    public $fillable = ['cve_compania', 'id_centrocosto', 'nombre_centrocosto', 'id_centrocosto_padre', 'cve_tipoCentroCosto', 'catalogo_sat'];
    protected $guarded = ['cve_compania'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'cve_compania';

}
