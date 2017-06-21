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

    public function get_centros_costo($cve_tipoCentroCosto) {
        $response = DB::table('ctb_cctipos_asociaciones')
                ->join('ctb_cat_centros_costo', 'ctb_cat_centros_costo.id_centrocosto', '=', 'ctb_cctipos_asociaciones.id_centrocosto')
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto', $cve_tipoCentroCosto)
                ->where('ctb_cat_centros_costo.estatus', 'A')
                ->select('ctb_cat_centros_costo.id_centrocosto', 'ctb_cat_centros_costo.id_centrocosto AS id', 'ctb_cat_centros_costo.id_centrocosto_padre', 'ctb_cat_centros_costo.cve_centrocosto AS cuenta_contable', DB::raw(' replace(ctb_cat_centros_costo.nombre_centrocosto,"|"," ") as text'))
                ->orderBy('ctb_cat_centros_costo.id_centrocosto_padre', 'asc')
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function get_concepto_financiero() {
        $response = DB::table('ctb_cat_concepto_financiero')
                ->where('estatus', 'A')
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function get_tipos_centros_costo() {
        $response = DB::table('ctb_tipos_centros_costo')
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function get_conceptofinanciero_edit($id_cuenta, $cve_tipoCentroCosto) {
        $response = DB::table('ctb_contabilidad_asociaciones')
                ->distinct()
                ->select('ctb_contabilidad_asociaciones.id_conceptofinanciero')
                ->join('ctb_cctipos_asociaciones', 'ctb_cctipos_asociaciones.id_centrocosto', '=', 'ctb_contabilidad_asociaciones.id_centrocosto')
                ->where('ctb_contabilidad_asociaciones.id_cuenta', $id_cuenta)
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto', $cve_tipoCentroCosto)
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function get_centros_costo_editar($id_cuenta) {
        $response = DB::table('ctb_contabilidad_asociaciones')
                ->distinct()
                ->select('id_centrocosto')
                ->where('id_cuenta', $id_cuenta)
                ->get()
                ->toArray();

        return response()->json($response);
    }

    public function editar_asociaciones(Request $request, $id_cuenta, $centros_costo_change) {
        unset($request['_token']);

//        Buscamos en la tabla ctb_contabilidad_asociaciones por tipo de centro costo y por el id 
//        y obtenemos id_contabilidad_asociacion para usarlo y eliminar las asociaciones 
         $response = DB::table('ctb_contabilidad_asociaciones')
                ->select('ctb_contabilidad_asociaciones.id_contabilidad_asociacion')
                ->join('ctb_cctipos_asociaciones', 'ctb_cctipos_asociaciones.id_centrocosto', '=', 'ctb_contabilidad_asociaciones.id_centrocosto')
                ->where('ctb_contabilidad_asociaciones.id_cuenta', $id_cuenta)
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto', $centros_costo_change)
                ->get()
                ->toArray();

        $id_contabilidad_asociacion = collect($response);
        $plucked = $id_contabilidad_asociacion->pluck('id_contabilidad_asociacion');

        DB::table('ctb_contabilidad_asociaciones')
                ->whereIn('id_contabilidad_asociacion', $plucked->all())
                ->delete();

        $data = array();
        
        foreach ($request->input('id_centrocosto') as $fila_id_centrocosto) {
            foreach ($request->input('id_conceptofinanciero') as $fila_id_conceptofinanciero) {
                array_push($data, array(
                    'id_cuenta' => $id_cuenta,
                    'id_centrocosto' => $fila_id_centrocosto,
                    'id_conceptofinanciero' => $fila_id_conceptofinanciero)
                );
            }
        }
        
        DB::table('ctb_contabilidad_asociaciones')
                ->insert($data);

        return response()->json();
    }

    public function index() {
        
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
