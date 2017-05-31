<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_departamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class nmn_cat_departamentosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = inv_cat_productos::paginate(6);

        $response = [
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ],
            'data' => $items
        ];
        return response()->json($response);
    }

    public function listar() {
        return view('nomina/nmn_cat_departamentos/index');
    }

    public function get_departamentos() {
        $response = DB::table('ctb_cctipos_asociaciones')
                ->join('ctb_cat_centros_costo', 'ctb_cat_centros_costo.id_centrocosto', '=', 'ctb_cctipos_asociaciones.id_centrocosto')
                ->where('cve_tipoCentroCosto', 'DEP')
                ->select('ctb_cat_centros_costo.id_centrocosto', 'ctb_cat_centros_costo.id_centrocosto AS id', 'ctb_cat_centros_costo.id_centrocosto_padre', DB::raw('replace(ctb_cat_centros_costo.nombre_centrocosto,"|","") as text'))
                ->get()
                ->toArray();
        
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $id_centrocosto = DB::table('ctb_cat_centros_costo')->insertGetId(
                array(
                    'cve_compania' => '019',
                    'nombre_centrocosto' => $request->input('nombre_centrocosto'),
                    'id_centrocosto_padre' => $request->input('id_centrocosto_padre'),
                    'estatus' => 'A'
                )
        );

        DB::table('ctb_cctipos_asociaciones')->insert(
                array(
                    'cve_compania' => '019',
                    'cve_tipoCentroCosto' => 'DEP',
                    'id_centrocosto' => $id_centrocosto,
                )
        );
        return response()->json($id_centrocosto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nomina\nmn_cat_departamentos  $nmn_cat_departamentos
     * @return \Illuminate\Http\Response
     */
    public function show(nmn_cat_departamentos $nmn_cat_departamentos) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nomina\nmn_cat_departamentos  $nmn_cat_departamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(nmn_cat_departamentos $nmn_cat_departamentos) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nomina\nmn_cat_departamentos  $nmn_cat_departamentos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nmn_cat_departamentos $nmn_cat_departamentos) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nomina\nmn_cat_departamentos  $nmn_cat_departamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(nmn_cat_departamentos $nmn_cat_departamentos) {
        //
    }

}
