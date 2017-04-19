<?php

namespace App\Http\Controllers\contabilidad;

use App\Models\contabilidad\Ctb_cat_concepto_financiero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ctb_cat_concepto_financieroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Ctb_cat_concepto_financiero::paginate(6);

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

        return view('contabilidad/Ctb_cat_concepto_financiero/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'cve_compania' => 'required|max:3',
            'cve_concepto_financiero' => 'required|max:6',
            'catalogo_sat' => 'required|max:6',
            'nombre_concepto' => 'required',
            'naturaleza' => 'required|max:1',
            'estatus' => 'required|max:1',
        ]);

        $create = Ctb_cat_concepto_financiero::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contabilidad\Ctb_cat_concepto_financiero  $ctb_cat_concepto_financiero
     * @return \Illuminate\Http\Response
     */
    public function show(Ctb_cat_concepto_financiero $ctb_cat_concepto_financiero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contabilidad\Ctb_cat_concepto_financiero  $ctb_cat_concepto_financiero
     * @return \Illuminate\Http\Response
     */
    public function edit(Ctb_cat_concepto_financiero $ctb_cat_concepto_financiero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\contabilidad\Ctb_cat_concepto_financiero  $ctb_cat_concepto_financiero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cve_compania' => 'required|max:3',
            'cve_concepto_financiero' => 'required|max:6',
            'catalogo_sat' => 'required|max:6',
            'nombre_concepto' => 'required',
            'naturaleza' => 'required|max:1',
            'estatus' => 'required|max:1',
        ]);
        $edit = Ctb_cat_concepto_financiero::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contabilidad\Ctb_cat_concepto_financiero  $ctb_cat_concepto_financiero
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Ctb_cat_concepto_financiero::find($id)->delete();
        return response()->json(['done']);
    }
}
