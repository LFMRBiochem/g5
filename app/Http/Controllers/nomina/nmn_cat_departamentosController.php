<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_departamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class nmn_cat_departamentosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listar() {
        return view('nomina/nmn_cat_departamentos/index');
    }

    public function get_departamentos() {
        $response = DB::table('ctb_cctipos_asociaciones')
                ->join('ctb_cat_centros_costo', 'ctb_cat_centros_costo.id_centrocosto', '=', 'ctb_cctipos_asociaciones.id_centrocosto')
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto', 'DEP')
                ->where('ctb_cat_centros_costo.estatus', 'A')
                ->select('ctb_cat_centros_costo.id_centrocosto', 'ctb_cat_centros_costo.id_centrocosto AS id', 'ctb_cat_centros_costo.id_centrocosto_padre', 'ctb_cat_centros_costo.cve_centrocosto', DB::raw(' replace(ctb_cat_centros_costo.nombre_centrocosto,"|"," ") as text'))
                ->orderBy('ctb_cat_centros_costo.id_centrocosto_padre', 'asc')
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
        unset($request['_token']);

        $validator = Validator::make($request->all(), [
                    'nombre_centrocosto' => 'required|max:75',
                    'cve_centrocosto' => 'required|max:8',
                        ], [
                    'nombre_centrocosto.required' => 'El campo es obligatorio.',
                    'nombre_centrocosto.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cve_centrocosto.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cve_centrocosto.required' => 'El campo es obligatorio.',
        ]);

        if ($validator->validate()) {
            return response()->json($validator->fails());
        } else {

            $id_centrocosto = DB::table('ctb_cat_centros_costo')->insertGetId(
                    array(
                        'cve_compania' => '019',
                        'nombre_centrocosto' => $request->input('nombre_centrocosto'),
                        'cve_centrocosto' => $request->input('cve_centrocosto'),
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
            return response()->json();
        }
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
    public function update(Request $request, $id) {
        unset($request['_token']);


        $validator = Validator::make($request->all(), [
                    'nombre_centrocosto' => 'required|max:75',
                    'cve_centrocosto' => 'required|max:8',
                        ], [
                    'nombre_centrocosto.required' => 'El campo es obligatorio.',
                    'nombre_centrocosto.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cve_centrocosto.required' => 'El campo es obligatorio.',
                    'cve_centrocosto.max' => 'El campo debe contener :max caracteres como máximo.'
        ]);

        if ($validator->validate()) {
            return response()->json($validator->fails());
        } else {

            DB::table('ctb_cat_centros_costo')
                    ->where('id_centrocosto', $id)
                    ->update(array(
                        'nombre_centrocosto' => $request->input('nombre_centrocosto'),
                        'id_centrocosto_padre' => $request->input('id_centrocosto'),
                        'cve_centrocosto' => $request->input('cve_centrocosto'),
            ));

            return response()->json();
        }
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
