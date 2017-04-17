<?php

namespace App\Http\Controllers\Contabilidad;

use App\Models\Contabilidad\Ctb_cat_monedas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ctb_cat_monedasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Ctb_cat_monedas::paginate(6);

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

        return view('contabilidad/Ctb_cat_monedas/index');
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
         $this->validate($request, [
            'cve_moneda' => 'required|max:3',
            'nombre_moneda' => 'required',
            'simbolo' => 'required|max:2',
            'posicion' => 'required|max:1',
            'numero_decimales' => 'required|numeric|max:9',
        ]);

        $create = Ctb_cat_monedas::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contabilidad\Ctb_cat_monedas  $ctb_cat_monedas
     * @return \Illuminate\Http\Response
     */
    public function show(Ctb_cat_monedas $ctb_cat_monedas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contabilidad\Ctb_cat_monedas  $ctb_cat_monedas
     * @return \Illuminate\Http\Response
     */
    public function edit(Ctb_cat_monedas $ctb_cat_monedas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contabilidad\Ctb_cat_monedas  $ctb_cat_monedas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         $this->validate($request, [
            'cve_moneda' => 'required|max:3',
            'nombre_moneda' => 'required',
            'simbolo' => 'required|max:2',
            'posicion' => 'required|max:1',
            'numero_decimales' => 'required|numeric|max:9',
        ]);
        $edit = Ctb_cat_monedas::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contabilidad\Ctb_cat_monedas  $ctb_cat_monedas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Ctb_cat_monedas::find($id)->delete();
        return response()->json(['done']);
    }
}
