<?php
namespace App\Modelss\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_bitacoracontable_encabezado extends Model{
	protected $table = 'ctb_bitacoracontable_encabezado';
	protected $primaryKey = 'id_foliobitacora';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'fecha_registro',
		'fecha_contable',
		'id_ejerciciofiscal',
		'tipo_transaccion',
		'concepto',
		'contabilizado',
		'contabilizado_en',
		'tipo_referencia',
		'cve_compania',
		'cve_documento_referencia',
		'num_documento_referencia',
		'cve_usuario'
	];
}
