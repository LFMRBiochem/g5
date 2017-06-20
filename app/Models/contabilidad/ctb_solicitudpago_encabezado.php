<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_solicitudpago_encabezado extends Model{
	protected $table = 'ctb_solicitudpago_encabezado';
	#protected $primaryKey = 'id_solicitudpago';
	#public $incrementing = false;
	public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'id_solicitudpago',
		'fecha_registro',
		'cve_moneda',
		'tipo_orden',
		'id_centrocosto',
		'cve_usuario_genero',
		'cve_usuario_autorizo',
		'comentarios',
		'instrucciones_pago',
		'id_tipo_cambio',
		'estatus',
		'importe_solicitado',
		'importe_depositado'
	];
}
