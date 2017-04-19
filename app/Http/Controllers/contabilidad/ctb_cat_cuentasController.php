<?php
namespace App\Http\Controllers\contabilidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contabilidad\ctb_cat_cuentas;
use App\Models\contabilidad\ctb_cat_concepto_financiero;
ini_set('max_execution_time', 300);
class ctb_cat_cuentasController extends Controller {
	public function ArbolDeCuentas(){
		return view('contabilidad.ctb_cat_cuentas');
	}
	public function index(Request $request){
		$cuentas = ctb_cat_cuentas::getCuentas($request['nivel']);
		$cuentas = [
			'descripcion'=>'Catálogo de Cuentas',
			'children'=>$cuentas
		];
		if($request['nivel'] >= 2){
			foreach($cuentas as $cuenta){
				$cuenta->children = $this->setConceptos($cuenta->catalogo_sat, $cuenta->children);
			}
		}
		return response()->json($cuentas);
	}
	public function setConceptos($catalogo_sat, $childrens){
		$total_conceptos = ctb_cat_concepto_financiero::getConceptos($catalogo_sat)->count();
		if($total_conceptos > 0)
			foreach($childrens as $children)
				$children->children = $this->getConceptos($children->catalogo_sat);
		else
			
		return $childrens;
	}
	public function getConceptos($catalogo_sat){
		return ctb_cat_concepto_financiero::getConceptos($catalogo_sat);
	}
}
