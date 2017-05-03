<?php

namespace App\Http\Controllers\compras;

use App\Models\compras\cmp_cat_proveedores;
use App\Models\contabilidad\ctb_cat_centros_costo;
use App\Models\contabilidad\ctb_cctipos_asociaciones;
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
        $create = cmp_cat_proveedores::get_proveedor_edit($id_proveedor);
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
        //Validamos 
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

        //Saber si existe el centro_costo
        $id_centrocosto = ctb_cat_centros_costo::get_id_centrocosto(array(
                    'cve_compania' => '019',
                    'nombre_centrocosto' => $request->input('razon_social'))
        );

        //Validar si existe el centro_costo en la tabla ctb_cat_centros_costo
        //Si existe el centro costo en la tabla ctb_cat_centros_costo
        if ($id_centrocosto) {

            $id_centrocosto = $id_centrocosto->id_centrocosto;
            //Obtenemos los tipo de asociacion
            $tipoCentroCosto = ctb_cctipos_asociaciones::get_cve_tipoCentroCosto(array(
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto)
            );
            //Verificamos que el tipo de asociacion sea CMF o CMM
            foreach ($tipoCentroCosto as $fila) {
                if ($fila->cve_tipoCentroCosto == 'CMF' || $fila->cve_tipoCentroCosto == 'CMM') {
                    //Bandera para saber si es un tipo CMF o CMM
                    $update_asociaciones = 1;
                    $folio_asociacion = $fila->folio_asociacion;
                }
            }

            // Si la cve_tipoCentroCosto contiene una de estas dos formas actualizar
            if ($update_asociaciones == 1) {
                //Actualizamos el tipo de Centro costo con ayuda del tipo persona insertado en el formulario
                ctb_cctipos_asociaciones::update_cve_tipoCentroCosto(array(
                    'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')), array(
                    'folio_asociacion' => $folio_asociacion
                        )
                );
                // Si la cve_tipoCentroCosto contiene ninguna de las formas insertar
            } else {
                //Insertamos el tipo de centro costo en la tabla ctb_cctipos_asociaciones
                ctb_cctipos_asociaciones::insert_cve_tipoCentroCosto(array('cve_compania' => '019', 'id_centrocosto' => $id_centrocosto, 'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')));
            }
            //Insertamos en la tabla cmp_cat_proveedores
            $create = cmp_cat_proveedores::create(array_merge($request->all(), array(
                        //Hacemos mayusculas los datos del RFC
                        'rfc' => strtoupper($request->input('rfc')),
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto,
                        'estatus' => 'A',
            )));
            //Si no existe el centro costo en la tabla ctb_cat_centros_costo
        } else {
            //Insertamos en ctb_cat_centros_costo el nombre del centro costo
            $id_centrocosto_nuevo = ctb_cat_centros_costo::insert_centro_costo(array(
                        'nombre_centrocosto' => strtoupper($request->input('razon_social')),
                        'cve_compania' => '019')
            );
            //Insertamos tipo de asociacion en la tabla ctb_cctipos_asociaciones
            ctb_cctipos_asociaciones::insert_tipos_asociaciones(array(
                'cve_compania' => '019',
                'id_centrocosto' => $id_centrocosto_nuevo,
                'cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona'))
            );

            //Insertamos en la tabla cmp_cat_proveedores el formulario
            $create = cmp_cat_proveedores::create(array_merge($request->all(), array(
                        //Hacemos mayusculas los datos del razon social
                        'razon_social' => strtoupper($request->input('razon_social')),
                        //Hacemos mayusculas los datos del RFC
                        'rfc' => strtoupper($request->input('rfc')),
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto_nuevo,
                        'estatus' => 'A',
            )));
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
        //Obtenemos el id_centrocosto 
        $id_centrocosto = ctb_cat_centros_costo::get_id_centrocosto(array('cve_compania' => '019', 'nombre_centrocosto' => $request->input('razon_social')));
        //Actualizamos la asociacion de la tabla ctb_cctipos_asociaciones
        ctb_cctipos_asociaciones::update_asociaciones(array('cve_tipoCentroCosto' => 'CM' . $request->input('tipo_persona')), array('id_centrocosto' => $id_centrocosto->id_centrocosto, 'cve_compania' => '019'));
        //Actualizamos al proveedor
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
        //Verificamos que estatus tiene actuamente el proveedor
        $db_estatus = cmp_cat_proveedores::get_estatus(array('id_proveedor' => $id));

        //Cambiamos de activo(A)  a cancelado(X)
        if ($db_estatus->estatus == 'A') {
            $estatus = 'X';
            //Cambiamos de cancelado(X) a activo(A)
        } else {
            $estatus = 'A';
        }

        //Buscamos el id del proveedor y actualizamos los datos
        cmp_cat_proveedores::find($id)->update(array(
            'estatus' => $estatus
        ));

        return response()->json(['done']);
    }

}
