<?php

namespace App\Http\Controllers\compras;

use App\Models\compras\cmp_cat_proveedores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class cmp_cat_proveedoresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $items = cmp_cat_proveedores::paginate(6);

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
        return view('compras/cmp_cat_proveedores/index');
    }

//    public function get_entidad() {
//        $create = DB::table('dgis_CAT_ENTIDADES')->
//                select('Cve_entidad as value', 'Estado as label')
//                ->get();
//        return response()->json($create);
//    }
//
//    public function get_municipio($Cve_entidad) {
//        $create = DB::table('dgis_CAT_MUNICIPIOS')
//                ->where('Cve_entidad', $Cve_entidad)
//                ->orderBy('Nom_municipio')
//                ->select('Nom_municipio as label', 'Cve_municipio as value')
//                ->get();
//
//        return response()->json($create);
//    }
//
//    public function get_localidad($Cve_municipio, $Cve_entidad) {
//        $create = DB::table('dgis_CAT_LOCALIDADES')
//                ->where('Cve_municipio', $Cve_municipio)
//                ->where('Cve_entidad', $Cve_entidad)
//                ->orderBy('Nom_localidad')
//                ->select('Nom_localidad as label', 'Cve_localidad as value')
//                ->get();
//
//        return response()->json($create);
//    }
//
//    public function get_banco() {
//        $create = DB::table('ctb_cat_bancos')
//                ->orderBy('nom_corto_banco')
//                ->select('nom_corto_banco as label', 'id_banco as value')
//                ->get();
//
//        return response()->json($create);
//    }
//
//    public function get_codigo_postal($Cve_municipio, $entidad) {
//        $values = DB::table('dgis_CODIGO_POSTAL')
//                ->where([
//                    ['Cve_municipio', $Cve_municipio],
//                    ['Cve_estado', $entidad],])
//                ->select('Codigo_postal', 'Asentamiento', 'Tipo_asentamiento')
//                ->get();
//
//        $create = array();
//        foreach ($values as $fila) {
//            array_push($create, array('value' => $fila->Codigo_postal . '|' . $fila->Asentamiento . '|' . $fila->Tipo_asentamiento, 'label' => '[' . $fila->Codigo_postal . '] ' . $fila->Asentamiento . ', ' . $fila->Tipo_asentamiento));
//        }
//        return response()->json($create);
//    }

    function get_proveedor_edit($id_proveedor) {
        $create = DB::table('cmp_cat_proveedores AS ccp')
                ->leftJoin('dgis_CAT_ENTIDADES AS ent', function($join) {
                    $join->on('ent.cve_entidad', '=', 'ccp.cve_entidad');
                })
                ->leftJoin('dgis_CAT_MUNICIPIOS AS mun', function($join) {
                    $join->on('mun.Cve_entidad', '=', 'ccp.cve_entidad');
                    $join->on('mun.Cve_municipio', '=', 'ccp.cve_municipio');
                })
                ->leftJoin('dgis_CAT_LOCALIDADES AS loc', function($join) {
                    $join->on('loc.Cve_entidad', '=', 'ccp.cve_entidad');
                    $join->on('loc.Cve_municipio', '=', 'ccp.cve_municipio');
                    $join->on('loc.Cve_localidad', '=', 'ccp.cve_localidad');
                })
                ->leftJoin('dgis_CODIGO_POSTAL AS cp', function($join) {
                    $join->on('cp.Cve_estado', '=', 'ccp.cve_entidad');
                    $join->on('cp.Cve_municipio', '=', 'ccp.cve_municipio');
                })
                ->leftJoin('ctb_cat_bancos AS ban', function($join) {
                    $join->on('ban.id_banco', '=', 'ccp.id_banco');
                })
                ->where('ccp.id_proveedor', '=', $id_proveedor)
                ->first();
        return response()->json($create);
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

        $this->validate($request, [
            'rfc' => 'sometimes|required|max:15',
            'razon_social' => 'required|max:75|min:4',
            'Codigo_pais' => 'required|max:11',
            'tipo_persona' => 'required',
            'Cve_entidad' => 'required|max:11',
            'Cve_municipio' => 'required|max:11',
            'Cve_localidad' => 'required|max:11',
            'Codigo_postal' => 'required|max:5',
            'Asentamiento' => 'required|max:60',
            'Tipo_asentamiento' => 'required|max:25',
            'telefonos' => 'required|max:50',
            'email' => 'required|max:100',
            'origen_bienes' => 'required|max:3',
            'limite_credito' => 'required|max:15',
            'dias_credito' => 'required|max:11',
            'atencion_pagos' => 'required|max:75',
            'atencion_ventas' => 'required|max:75',
            'id_banco' => 'required|max:11',
            'CLABE' => 'required|max:18',
        ]);


        $id_centrocosto = DB::table('ctb_cat_centros_costo')
                ->where('cve_compania', '019')
                ->where('nombre_centrocosto', $request->input('razon_social'))
                ->select('id_centrocosto')
                ->first();

        $create = cmp_cat_proveedores::create(array_merge($request->all(), [
                    'cve_compania' => '019',
                    'id_centrocosto' => $id_centrocosto->id_centrocosto,
                    'estatus' => 'A',
        ]));
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Compras\Cmp_cat_proveedores  $cmp_cat_proveedores
     * @return \Illuminate\Http\Response
     */
    public function show(Cmp_cat_proveedores $cmp_cat_proveedores) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Compras\Cmp_cat_proveedores  $cmp_cat_proveedores
     * @return \Illuminate\Http\Response
     */
    public function edit(Cmp_cat_proveedores $cmp_cat_proveedores) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Compras\Cmp_cat_proveedores  $cmp_cat_proveedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'rfc' => 'sometimes|required|max:15',
            'razon_social' => 'required|max:75|min:4',
            'Codigo_pais' => 'required|max:11',
            'tipo_persona' => 'required',
            'Cve_entidad' => 'required|max:11',
            'Cve_municipio' => 'required|max:11',
            'Cve_localidad' => 'required|max:11',
            'Codigo_postal' => 'required|max:5',
            'Asentamiento' => 'required|max:60',
            'Tipo_asentamiento' => 'required|max:25',
            'telefonos' => 'required|max:50',
            'email' => 'required|max:100',
            'origen_bienes' => 'required|max:3',
            'limite_credito' => 'required|max:15',
            'dias_credito' => 'required|max:11',
            'atencion_pagos' => 'required|max:75',
            'atencion_ventas' => 'required|max:75',
            'id_banco' => 'required|max:11',
            'CLABE' => 'required|max:18',
        ]);

        $id_centrocosto = DB::table('ctb_cat_centros_costo')
                ->where('cve_compania', '019')
                ->where('nombre_centrocosto', $request->input('razon_social'))
                ->select('id_centrocosto')
                ->first();

        $edit = cmp_cat_proveedores::find($id)->update(array_merge($request->all(), [
            'cve_compania' => '019',
            'id_centrocosto' => $id_centrocosto->id_centrocosto,
            'estatus' => 'A',
        ]));
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Compras\Cmp_cat_proveedores  $cmp_cat_proveedores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        cmp_cat_proveedores::find($id)->delete();
        return response()->json(['done']);
    }

}
