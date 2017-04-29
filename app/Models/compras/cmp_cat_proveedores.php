<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;
use DB;

class cmp_cat_proveedores extends Model {

    // Seleccionamos la tabla de CMP_cat_proveedores
    protected $table = 'cmp_cat_proveedores';
    // Campos de la tabla que se modificaran masivamente
    public $fillable = [
        'cve_compania',
        'id_centrocosto',
        'rfc',
        'tipo_persona',
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
    //Quitamos que busque variable incremental id
    public $incrementing = false;
    //Quitamos el campo de $timestamps porque no lo tenemos
    public $timestamps = false;
    //Decimos que id_proveedor es nuestra llave primaria
    public $primaryKey = 'id_proveedor';

    //Funcion para seleccionar
    public static function get_proveedor_edit($id_proveedor) {
        return DB::table('cmp_cat_proveedores AS ccp')
                        ->leftJoin('dgis_CAT_ENTIDADES AS ent', function($join) {
                            $join->on('ent.cve_entidad', '=', 'ccp.cve_entidad');
                        })
                        ->leftJoin('dgis_CAT_MUNICIPIOS AS mun', function($join) {
                            $join->on('mun.Cve_entidad', '=', 'ccp.cve_entidad');
                            $join->on('mun.Cve_municipio', '=', 'ccp.cve_municipio');
                        })
                        ->leftJoin('dgis_CAT_LOCALIDADES AS loc', function($join) {
                            $join->on('loc.Cve_entidad', '=', 'ccp.cve_entidad');
                            $join->on('loc.Cve_municipio', '=', 'ccp.cve_municipio');
                            $join->on('loc.Cve_localidad', '=', 'ccp.cve_localidad');
                        })
                        ->leftJoin('dgis_CODIGO_POSTAL AS cp', function($join) {
                            $join->on('cp.Cve_estado', '=', 'ccp.cve_entidad');
                            $join->on('cp.Cve_municipio', '=', 'ccp.cve_municipio');
                        })
                        ->leftJoin('ctb_cat_bancos AS ban', function($join) {
                            $join->on('ban.id_banco', '=', 'ccp.id_banco');
                        })
                        ->where('ccp.id_proveedor', '=', $id_proveedor)
                        ->first();
    }

    public static function get_estatus($data) {
        return DB::table('cmp_cat_proveedores')
                        ->where($data)
                        ->select('estatus')
                        ->first();
    }

}
