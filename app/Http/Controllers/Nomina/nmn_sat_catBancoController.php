<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\Nmn_sat_catBanco;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class nmn_sat_catBancoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = Nmn_sat_catBanco::paginate(6);

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
//        Crear variable de session
//        $request->session()->put('key', 'value');
//        Imprimir variable de session
//        $value = $request->session()->get('key');
//        Borrar variable de session
//        $request->session()->flush() ;
        return view('nomina/nmn_sat_catbanco/index');
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
            'cve_banco' => 'required|max:3',
            'nombre_banco' => 'required|max:40',
            'razon_social' => 'required|max:120',
        ]);

        $create = Nmn_sat_catBanco::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\nomina\Nmn_sat_catBanco  $nmn_sat_catBanco
     * @return \Illuminate\Http\Response
     */
    public function show(Nmn_sat_catBanco $nmn_sat_catBanco) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\nomina\Nmn_sat_catBanco  $nmn_sat_catBanco
     * @return \Illuminate\Http\Response
     */
    public function edit(Nmn_sat_catBanco $nmn_sat_catBanco) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\nomina\Nmn_sat_catBanco  $nmn_sat_catBanco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'nombre_banco' => 'required|max:40',
            'razon_social' => 'required|max:120',
        ]);
        $edit = Nmn_sat_catBanco::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\nomina\Nmn_sat_catBanco  $nmn_sat_catBanco
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        Nmn_sat_catBanco::find($id)->delete();
        return response()->json(['done']);
    }

}
