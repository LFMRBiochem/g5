<?php
namespace App\Http\Controllers\compras;

use App\Models\compras\cmp_cat_proveedores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class cmp_cat_proveedoresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $items = cmp_cat_proveedores::paginate(15);

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
            'rfc' => 'sometimes|required|min:10|max:15',
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
            'email' => 'required|max:100|email',
            'origen_bienes' => 'required|max:3',
            'limite_credito' => 'required|max:15',
            'dias_credito' => 'required|max:11',
            'atencion_pagos' => 'required|max:75',
            'atencion_ventas' => 'required|max:75',
            'id_banco' => 'required|max:11',
            'CLABE' => 'required|digits:18',
        ]);

//          Saber si existe el centro_costo
        $id_centrocosto = DB::table('ctb_cat_centros_costo')
                ->where('cve_compania', '019')
                ->where('nombre_centrocosto', $request->input('razon_social'))
                ->select('id_centrocosto')
                ->first();


//          Validar si existe el centro_costo en la tabla ctb_cat_centros_costo
        if ($id_centrocosto) { //si existe el centro costo en la tabla ctb_cat_centros_costo
            $id_centrocosto = $id_centrocosto->id_centrocosto;

            $tipoCentroCosto = DB::table('ctb_cctipos_asociaciones')
                            ->where('cve_compania', '019')
                            ->where('id_centrocosto', $id_centrocosto)
                            ->select('cve_tipoCentroCosto', 'folio_asociacion')
                            ->get()->toArray();

            print_r($tipoCentroCosto);
            print_r('foreach');
            foreach ($tipoCentroCosto as $fila) {
                if ($fila->cve_tipoCentroCosto == 'CMF' || $fila->cve_tipoCentroCosto == 'CMM') {
                    $update_asociaciones = 1;
                    $folio_asociacion = $fila->folio_asociacion;
                }
            }
            print_r('if $update_asociaciones');
            if ($update_asociaciones == 1) { // si la cve_tipoCentroCosto contiene una de estas dos formas actualizar
                DB::table('ctb_cctipos_asociaciones')
                        ->where('folio_asociacion', $folio_asociacion)
                        ->update(['cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')]);
            } else {// si la cve_tipoCentroCosto contiene ninguna de las formas insertar
                print_r('else $update_asociaciones');
                DB::table('ctb_cctipos_asociaciones')->insert(
                        ['cve_compania' => '019',
                            'id_centrocosto' => $id_centrocosto,
                            'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')]
                );

                print_r('create');
//                insertamos en la tabla cmp_cat_proveedores
            }
            $create = cmp_cat_proveedores::create(array_merge($request->all(), [
                        'rfc' => strtoupper($request->input('rfc')),
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto,
                        'estatus' => 'A',
            ]));
        } else {//si no existe el centro costo en la tabla ctb_cat_centros_costo
            $id_centrocosto_nuevo = DB::table('ctb_cat_centros_costo')->insertGetId(
                    ['nombre_centrocosto' => $request->input('razon_social'), 'cve_compania' => '019']
            );
            DB::table('ctb_cctipos_asociaciones')->insert(
                    ['cve_compania' => '019', 'id_centrocosto' => $id_centrocosto_nuevo, 'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')]
            );
            //                insertamos en la tabla cmp_cat_proveedores
            $create = cmp_cat_proveedores::create(array_merge($request->all(), [
                        'rfc' => strtoupper($request->input('rfc')),
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto_nuevo,
                        'estatus' => 'A',
            ]));
        }

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

//        DB::table('ctb_cctipos_asociaciones')->insert(
//                ['id_centrocosto' => $id_centrocosto, 'cve_compania' => '019', 'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')]
//        );
        DB::table('ctb_cctipos_asociaciones')
                ->where('id_centrocosto', $id_centrocosto->id_centrocosto)
                ->where('cve_compania', '019')
                ->where('cve_tipoCentroCosto', 'CMM')
                ->orWhere('cve_tipoCentroCosto', 'CMF')
                ->update(['cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')]);


        $edit = cmp_cat_proveedores::find($id)->update(array_merge($request->all(), [
            'cve_compania' => '019',
            'id_centrocosto' => $id_centrocosto->id_centrocosto,
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
        $db_estatus = DB::table('cmp_cat_proveedores')
                ->where('id_proveedor', $id)
                ->select('estatus')
                ->first();

        if ($db_estatus->estatus == 'A') {
            $estatus = 'X';
        } else {
            $estatus = 'A';
        }
        cmp_cat_proveedores::find($id)->update([
            'estatus' => $estatus,
        ]);
        return response()->json(['done']);
    }

}
