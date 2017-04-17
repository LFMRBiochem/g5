<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_cat_concepto_financiero extends Model{
	protected $table = 'ctb_cat_concepto_financiero';
	protected $primaryKey = 'id_conceptofinanciero';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'cve_concepto_financiero',
		'catalogo_sat',
		'nombre_concepto'
		'naturaleza',
		'estatus'
	];
}
