<?php

namespace App\Http\Controllers\Contabilidad;

use App\Models\Contabilidad\Ctb_cat_centros_costo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ctb_cat_centros_costoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = Ctb_cat_centros_costo::paginate(6);

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

        return view('contabilidad/ctb_cat_centros_costo/index');
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
        //
        $this->validate($request, [
            'cve_compania' => 'required|max:3',
            'id_centrocosto' => 'required|max:20',
            'nombre_centrocosto' => 'required|max:75',
            'id_centrocosto_padre' => 'required|max:20',
            'cve_tipoCentroCosto' => 'required|max:3',
            'catalogo_sat' => 'required|max:6',
        ]);

        $create = Ctb_cat_centros_costo::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Contabilidad\Ctb_cat_centros_costo  $ctb_cat_centros_costo
     * @return \Illuminate\Http\Response
     */
    public function show(Ctb_cat_centros_costo $ctb_cat_centros_costo) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Contabilidad\Ctb_cat_centros_costo  $ctb_cat_centros_costo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ctb_cat_centros_costo $ctb_cat_centros_costo) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Contabilidad\Ctb_cat_centros_costo  $ctb_cat_centros_costo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'id_centrocosto' => 'required|max:20',
            'nombre_centrocosto' => 'required|max:75',
            'id_centrocosto_padre' => 'required|max:20',
            'cve_tipoCentroCosto' => 'required|max:3',
            'catalogo_sat' => 'required|max:6',
        ]);
        $edit = Ctb_cat_centros_costo::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Contabilidad\Ctb_cat_centros_costo  $ctb_cat_centros_costo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        Ctb_cat_centros_costo::find($id)->delete();
        return response()->json(['done']);
    }

}
