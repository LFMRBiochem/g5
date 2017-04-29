<?php
namespace App\Http\Controllers\tesoreria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\tesoreria\ctb_cat_bancos;

class ctb_cat_bancosController extends Controller{
	public function Bancos(){
		return view('tesoreria/ctb_cat_bancos');
	}
	public function index(Request $request){
		$bancos = ctb_cat_bancos::paginate($request['xPag']);
		foreach($bancos as $banco){
			$banco->active_class = false;
		}
		$response = [
			'pagination' => [
				'total'=>$bancos->total(),
				'per_page'=>$bancos->perPage(),
				'current_page'=>$bancos->currentPage(),
				'last_page'=>$bancos->lastPage(),
				'from'=>$bancos->firstItem(),
				'to'=>$bancos->lastItem()
			],
			'data'=>$bancos
		];
		return response()->json($response);
	}
	public function store(Request $request){
		$this->validate($request, [
			'cve_banco'=>'required',
			'nom_corto_banco'=>'required',
			'nom_banco'=>'required'
		]);
		$create = ctb_cat_bancos::create($request->all());
		return response()->json($create);
	}
	public function update(Request $request, $id){
		$this->validate($request, [
			'cve_banco'=>'required',
			'nom_corto_banco'=>'required',
			'nom_banco'=>'required'
		]);
		$edit = ctb_cat_bancos::find($id)->update($request->all());
		return response()->json($edit);
	}
	public function destroy($id){
		ctb_cat_bancos::find($id)->delete();
		return response()->json(['done']);
	}
}
