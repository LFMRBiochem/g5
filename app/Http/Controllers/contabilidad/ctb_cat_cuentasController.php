<?php

namespace App\Http\Controllers\contabilidad;

use App\Models\contabilidad\ctb_cat_cuentas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class ctb_cat_cuentasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar() {
        return view('contabilidad/ctb_cat_cuentas/index');
    }

    public function get_cuentas() {
        $response = DB::table('ctb_cat_cuentas')
                ->select('id_cuenta  AS id', 'cuenta_contable', 'naturaleza', 'descripcion AS text', 'cve_moneda', 'id_cuenta_padre')
                ->orderBy('ctb_cat_cuentas.id_cuenta_padre', 'asc')
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function index() {
        //
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
                    'descripcion' => 'required|max:160',
                    'cuenta_contable' => 'required|max:20',
                    'naturaleza' => 'required'
                        ], [
                    'descripcion.required' => 'El campo es obligatorio.',
                    'descripcion.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cuenta_contable.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cuenta_contable.required' => 'El campo es obligatorio.',
                    'naturaleza.required' => 'El campo es obligatorio.'
        ]);

        if ($validator->validate()) {
            return response()->json($validator->fails());
        } else {
            DB::table('ctb_cat_cuentas')->insertGetId(
                    array(
                        'cve_compania' => '019',
                        'cuenta_contable' => $request->input('cuenta_contable'),
                        'naturaleza' => $request->input('naturaleza'),
                        'descripcion' => $request->input('descripcion'),
                        'cve_moneda' => 'MXN',
                        'id_cuenta_padre' => $request->input('id_cuenta_padre'),
                        'estatus' => 'A'
                    )
            );
            return response()->json();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        unset($request['_token']);

        $validator = Validator::make($request->all(), [
                    'descripcion' => 'required|max:160',
                    'cuenta_contable' => 'required|max:20',
                    'naturaleza' => 'required'
                        ], [
                    'descripcion.required' => 'El campo es obligatorio.',
                    'descripcion.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cuenta_contable.max' => 'El campo debe contener :max caracteres como máximo.',
                    'cuenta_contable.required' => 'El campo es obligatorio.',
                    'naturaleza.required' => 'El campo es obligatorio.'
        ]);

        if ($validator->validate()) {
            return response()->json($validator->fails());
        } else {
            DB::table('ctb_cat_cuentas')
                    ->where('id_cuenta', $id)
                    ->update(
                            array(
                                'cuenta_contable' => $request->input('cuenta_contable'),
                                'naturaleza' => $request->input('naturaleza'),
                                'descripcion' => $request->input('descripcion'),
                                'id_cuenta_padre' => $request->input('id_cuenta_padre'),
                            )
            );
            return response()->json();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
