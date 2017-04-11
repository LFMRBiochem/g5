<?php
namespace App\Http\Controllers\contabilidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\contabilidad\ctb_cat_cuentas;
class ctb_cat_cuentasController extends Controller {
	public function ArbolDeCuentas(){
		return view('contabilidad.ctb_cat_cuentas');
	}
	public function index(){
		$cuentas = CtbCatCuenta::getCuentas();
		$cuentas = [
			'name'=>'Catálogo de Cuentas',
			'children'=>$cuentas
		];
		return response()->json($cuentas);
	}
}
