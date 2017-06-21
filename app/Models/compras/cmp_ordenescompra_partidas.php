<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;

class cmp_ordenescompra_partidas extends Model
{
    protected $table = 'cmp_ordenescompra_partidas';
    public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'num_orden',
		'num_partida',
		'folio_GTIN',
		'descripcion_complementaria',
		'cantidad',
		'precio_unitario',
		'porcentaje_impuesto',
		'cantidad_recibida',
		'cve_unidad_medida',
		'estatus'
	];
}
