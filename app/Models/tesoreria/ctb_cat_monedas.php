<?php
namespace App\Models\tesoreria;
use Illuminate\Database\Eloquent\Model;

class ctb_cat_monedas extends Model{
	protected $table = 'ctb_cat_monedas';
	protected $primaryKey = 'cve_moneda';
	public $incrementing = false;
	public $timestamps = false;
	public $fillable = [
		'cve_moneda',
		'nombre_moneda',
		'simbolo',
		'posicion',
		'numero_decimales'
	];
}
