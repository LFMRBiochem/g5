<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;

class Cmp_cat_proveedores extends Model {

    //
    protected $table = 'cmp_cat_proveedores';
    public $fillable = [
        'cve_compania',
        'id_centrocosto',
        'rfc',
        'razon_social',
        'Codigo_pais',
        'Cve_entidad',
        'Cve_municipio',
        'Cve_localidad',
        'Codigo_postal',
        'Asentamiento',
        'Tipo_asentamiento',
        'telefonos',
        'email',
        'origen_bienes',
        'limite_credito',
        'dias_credito',
        'atencion_pagos',
        'atencion_ventas',
        'id_banco',
        'CLABE',
        'estatus'
        ];
//    protected $guarded = ['cve_compania'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_proveedor';

}
