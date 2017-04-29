<?php

namespace App\Models\contabilidad;

use Illuminate\Database\Eloquent\Model;
use DB;

class ctb_cat_centros_costo extends Model {

    // Seleccionamos la tabla de CMP_cat_proveedores
    protected $table = 'ctb_cat_centros_costo';
    // Campos de la tabla que se modificaran masivamente
    public $fillable = [
        'cve_compania',
        'id_centrocosto',
        'nombre_centrocosto',
        'id_centrocosto_padre',
        'cve_tipoCentroCosto',
        'catalogo_sat'
    ];
    protected $guarded = ['cve_compania'];
    //Quitamos que busque variable incremental id
    public $incrementing = false;
    //Quitamos el campo de $timestamps porque no lo tenemos
    public $timestamps = false;
    //Decimos nuestra llave primaria
    public $primaryKey = 'cve_compania';

    public static function get_id_centrocosto($data) {
        return DB::table('ctb_cat_centros_costo')
                        ->where($data)
                        ->select('id_centrocosto')
                        ->first();
    }

    public static function insert_centro_costo($data) {
        return DB::table('ctb_cat_centros_costo')
                        ->insertGetId($data);
    }

}
