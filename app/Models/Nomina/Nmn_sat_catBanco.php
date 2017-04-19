<?php

namespace App\Models\Nomina;

use Illuminate\Database\Eloquent\Model;

class Nmn_sat_catBanco extends Model {

    //
    protected $table = 'nmn_sat_catbanco';
    public $fillable = ['cve_banco', 'nombre_banco', 'razon_social'];
//    protected $guarded = ['cve_compania'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'cve_banco';

}
