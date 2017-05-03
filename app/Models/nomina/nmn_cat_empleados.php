<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class nmn_cat_empleados extends Model {

    //

    protected $table = 'nmn_cat_empleados';
    public $fillable = ['id_empleado',
        'cve_compania',
        'num_empleado',
        'nombre_empleado',
        'primer_apellido',
        'segundo_apellido',
        'codigo_pais',
        'cve_entidad',
        'cve_municipio',
        'cve_localidad',
        'codigo_postal',
        'asentamiento',
        'tipo_asentamiento',
        'calle_domicilio',
        'num_exterior',
        'num_interior',
        'telefono_casa',
        'telefono_celular',
        'telefono_otro',
        'correo_electronico',
        'rfc',
        'curp',
        'numero_seguro_social',
        'id_centrocosto',
        'fecha_registro',
        'cve_banco',
        'cuenta_bancaria',
        'estatus',];
//    protected $guarded = ['cve_compania'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_empleado';

    //Funcion para seleccionar
    public static function get_empleados_edit($id_empleado) {
        return DB::table('nmn_cat_empleados AS ccp')
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
                            $join->on('ban.cve_banco', '=', 'ccp.cve_banco');
                        })
                        ->leftJoin('ctb_cat_centros_costo AS cc', function($join) {
                            $join->on('cc.id_centrocosto', '=', 'ccp.id_centrocosto');
                        })
                        ->where('ccp.id_empleado', '=', $id_empleado)
                        ->first();
    }

    public static function get_estatus($data) {
        return DB::table('nmn_cat_empleados')
                        ->where($data)
                        ->select('estatus')
                        ->first();
    }

}
