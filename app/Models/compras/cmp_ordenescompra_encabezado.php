<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;

class cmp_ordenescompra_encabezado extends Model
{
    protected $table = 'cmp_ordenescompra_encabezado';
    public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'num_orden',
		'id_proveedor',
		'fecha_registro',
		'fecha_entrega',
		'usuario_registra',
		'usuario_solicita',
		'usuario_autoriza',
		'uruario_represente_legal',
		'comentarios',
		'lugar_entrega',
		'condiciones_entrega',
		'condiciones_pago',
		'bitacora_seguimiento',
		'cve_moneda',
		'tipo_cambio',
		'estatus'
	];
}
