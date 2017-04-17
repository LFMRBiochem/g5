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
		'naturaleza',
		'descripcion',
		'id_cuenta_padre',
		'nivel',
		'cve_moneda',
		'estatus'
	];
	public static function getPadres(){
		$cuentas = DB::table('ctb_cat_cuentas')
			->select('id_cuenta', 'cuenta_contable', 'naturaleza', 'descripcion', 'cve_moneda', 'estatus')
			->where([
					['cve_compania', '019'],
					['id_cuenta_padre', null],
					['nivel', 0]
				])
			->get();
		return $cuentas;
	}
	public static function getCuentas($nivel){
		$cuentas = self::getPadres();
		foreach($cuentas as $cuenta){
			$cuenta->children = self::getHijas($cuenta->id_cuenta, $nivel);
		}
		return $cuentas;
	}
	public static function getHijas($id_cuenta_padre, $nivel){
		$cuentasHijas = DB::table('ctb_cat_cuentas')
			->select('id_cuenta', 'cuenta_contable', 'naturaleza', 'descripcion', 'cve_moneda', 'estatus')
			->where([
					['cve_compania', '019'],
					['id_cuenta_padre', $id_cuenta_padre],
					['nivel', '<=', 1]
				])
			->get();
		foreach($cuentasHijas as $cuentaHija){
			$cuentaHija->children = self::getHijas($cuentaHija->id_cuenta, $nivel);
		}
		return $cuentasHijas;
	}
}
