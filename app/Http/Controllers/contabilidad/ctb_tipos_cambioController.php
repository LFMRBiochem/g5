<?php

namespace App\Http\Controllers\Contabilidad;

use App\Models\Contabilidad\Ctb_tipos_cambio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ctb_tipos_cambioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = Ctb_tipos_cambio::paginate(6);

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

        return view('Contabilidad/ctb_tipos_cambio/index');
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
            'cve_moneda' => 'required|numeric|max:3',
            'fecha' => 'required|date',
            'tipo_cambio' => 'required|numeric|max:18',
        ]);

        $create = Ctb_tipos_cambio::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Contabilidad\Cbt_tipos_cambio  $cbt_tipos_cambio
     * @return \Illuminate\Http\Response
     */
    public function show(Cbt_tipos_cambio $cbt_tipos_cambio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Contabilidad\Cbt_tipos_cambio  $cbt_tipos_cambio
     * @return \Illuminate\Http\Response
     */
    public function edit(Cbt_tipos_cambio $cbt_tipos_cambio) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Contabilidad\Cbt_tipos_cambio  $cbt_tipos_cambio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'cve_moneda' => 'required|max:3',
            'fecha' => 'required',
            'tipo_cambio' => 'required|max:18',
        ]);
        $edit = Ctb_tipos_cambio::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Contabilidad\Cbt_tipos_cambio  $cbt_tipos_cambio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        Ctb_tipos_cambio::find($id)->delete();
        return response()->json(['done']);
    }

}
