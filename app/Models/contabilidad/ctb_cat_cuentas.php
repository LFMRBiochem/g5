<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ctb_cat_cuentas extends Model{
	protected $table = 'ctb_cat_cuentas';
	protected $primaryKey = 'id_cuenta';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'cuenta_contable',
		'tipo_cuenta',
		'naturaleza',
		'descripcion',
		'id_cuenta_padre',
		'nivel',
		'cve_moneda',
		'estatus'
	];
	public static function getCuentas(){
		$cuentas = DB::table('ctb_cat_cuenta')
			->where('id_cuenta_padre', null)
			->select('id_cuenta', 'cuenta_contable', 'tipo_cuenta', 'naturaleza', 'descripcion as name', 'cve_moneda', 'estatus')
			->get();
		foreach($cuentas as $cuenta){
			$cuenta->children = self::getHijas($cuenta->id_cuenta);
		}
		return $cuentas;
	}
	public static function getHijas($id_cuenta_padre){
		$cuentasHijas = DB::table('ctb_cat_cuenta')
			->where('id_cuenta_padre', $id_cuenta_padre)
			->select('id_cuenta', 'cuenta_contable', 'tipo_cuenta', 'naturaleza', 'descripcion as name', 'cve_moneda', 'estatus')
			->get();
		foreach($cuentasHijas as $cuentaHija){
			$cuentaHija->children = self::getHijas($cuentaHija->id_cuenta);
		}
		return $cuentasHijas;
	}
}
