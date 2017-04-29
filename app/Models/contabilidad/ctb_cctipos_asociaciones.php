<?php

namespace App\Models\contabilidad;

use Illuminate\Database\Eloquent\Model;
use DB;

class ctb_cctipos_asociaciones extends Model {

    public static function get_cve_tipoCentroCosto($data) {
        return DB::table('ctb_cctipos_asociaciones')
                        ->where($data)
                        ->select('cve_tipoCentroCosto', 'folio_asociacion')
                        ->get()->toArray();
    }

    public static function update_cve_tipoCentroCosto($update, $data) {

        return DB::table('ctb_cctipos_asociaciones')
                        ->where($data)
                        ->update($update);
    }

    public static function insert_cve_tipoCentroCosto($data) {
        return DB::table('ctb_cctipos_asociaciones')->insert($data);
    }

    public static function insert_tipos_asociaciones($data) {
        return DB::table('ctb_cctipos_asociaciones')->insert($data);
    }

    public static function update_asociaciones($update, $data) {
        return DB::table('ctb_cctipos_asociaciones')
                        ->where($data)
                        ->where('cve_tipoCentroCosto', 'CMM')
                        ->orWhere('cve_tipoCentroCosto', 'CMF')
                        ->update($update);
    }

}
