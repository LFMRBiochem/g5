<?php

namespace App\Models\Autentificacion;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model {

    protected $table = 'SYSCAT_USUARIOS';
    public $fillable = ['Cve_usuario', 'Nombre','Password'];
//    protected $guarded = ['cve_proveedor'];
//  public $fillable = ['cve_compania','nombre_proveedor'];
    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = 'Cve_usuario';

}
