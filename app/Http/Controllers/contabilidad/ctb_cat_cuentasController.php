<?php
namespace App\Http\Controllers\contabilidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contabilidad\ctb_cat_cuentas;
#ini_set('max_execution_time', 300);
class ctb_cat_cuentasController extends Controller {
	public function ArbolDeCuentas(){
		return view('contabilidad.ctb_cat_cuentas');
	}
	public function index(){
		$cuentas = ctb_cat_cuentas::getCuentas();
		$cuentas = [
			'name'=>'Catálogo de Cuentas',
			'children'=>$cuentas
		];
		return response()->json($cuentas);
	}
}
