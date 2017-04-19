<?php

namespace App\Models\autentificacion;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model {

    protected $table = 'SYSCAT_USUARIOS';
    public $fillable = ['Cve_usuario', 'Nombre', 'Password'];
//    protected $guarded = ['cve_proveedor'];
//  public $fillable = ['cve_compania','nombre_proveedor'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'Cve_usuario';

    public static function login($request) {
        unset($request['_token']);
        return DB::table('SYSCAT_USUARIOS')->where($request)->first();
    }

}
