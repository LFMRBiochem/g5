<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Model;

class syscat_usuariostransacciones extends Model {

    //
    protected $table = 'SYSCAT_USUARIOSTRANSACCIONES';
    public $fillable = ['Cve_usuario','Cve_transaccion','cve_compania'];
    protected $guarded = ['cve_compania'];
//  public $fillable = ['cve_compania','nombre_proveedor'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'folio_usrTransaccion';

}
