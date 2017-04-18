<?php

namespace App\Models\Autentificacion;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model {

    protected $table = 'syscat_usuarios';
    public $fillable = ['Cve_usuario', 'Nombre', 'Password'];
//    protected $guarded = ['cve_proveedor'];
//  public $fillable = ['cve_compania','nombre_proveedor'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'Cve_usuario';

    public static function login($request) {
        unset($request['_token']);
        return DB::table('syscat_usuarios')->where($request)->first();
    }

}
