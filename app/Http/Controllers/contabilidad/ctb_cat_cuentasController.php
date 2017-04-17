<?php
namespace App\Http\Controllers\contabilidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contabilidad\ctb_cat_cuentas;
ini_set('max_execution_time', 300);
class ctb_cat_cuentasController extends Controller {
	public function ArbolDeCuentas(){
		return view('contabilidad.ctb_cat_cuentas');
	}
	public function index(Request $request){
		if($request['nivel'] == 0){
			$cuentas = ctb_cat_cuentas::getPadres();
			$cuentas = [
				'descripcion'=>'Cuentas de mayor',
				'children'=>$cuentas
			];
		} elseif($request['nivel'] > 0 && $request['nivel'] <= 3){
			$cuentas = ctb_cat_cuentas::getCuentas($request['nivel']);
			$cuentas = [
				'descripcion'=>'Catálogo de cuentas nivel '.$request['nivel'],
				'children'=>$cuentas
			];
		}
		return response()->json($cuentas);
	}
}
