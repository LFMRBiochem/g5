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
	public static function getCuentas(){
		$cuentas = DB::table('ctb_cat_cuentas')
			->select('id_cuenta', 'cuenta_contable', 'naturaleza', 'descripcion as name', 'cve_moneda', 'estatus')
			->where([
					['cve_compania', '019'],
					['id_cuenta_padre', null]
				])
			->get();
		foreach($cuentas as $cuenta){
			$cuenta->children = self::getHijas($cuenta->id_cuenta);
		}
		return $cuentas;
	}
	public static function getHijas($id_cuenta_padre){
		$cuentasHijas = DB::table('ctb_cat_cuentas')
			->select('id_cuenta', 'cuenta_contable', 'naturaleza', 'descripcion as name', 'cve_moneda', 'estatus')
			->where([
					['cve_compania', '019'],
					['id_cuenta_padre', $id_cuenta_padre]
				])
			->get();
		foreach($cuentasHijas as $cuentaHija){
			$cuentaHija->children = self::getHijas($cuentaHija->id_cuenta);
		}
		return $cuentasHijas;
	}
}
