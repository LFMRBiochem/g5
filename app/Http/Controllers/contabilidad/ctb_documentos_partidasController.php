<?php

namespace App\Http\Controllers\Contabilidad;

use App\Models\Contabilidad\Ctb_documentos_partidas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ctb_documentos_partidasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = Ctb_documentos_partidas::paginate(6);

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
        return view('contabilidad/ctb_documentos_partidas/index');
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
            'folio_documento' => 'required|max:20',
            'num_partida' => 'required|max:10',
            'id_conceptofinanciero' => 'required|max:20',
            'descripcion_complementaria' => 'required|max:255',
            'cantidad' => 'required|max:19',
            'cve_unidad_medida' => 'required|max:7',
            'precio_unitario' => 'required|max:13',
            'porcentaje_impuesto' => 'required|max:13',
            'porcentaje_descuento' => 'required|max:13',
            'subtotal' => 'required|max:13',
            'total_partida' => 'required|max:13',
        ]);

        $create = Ctb_documentos_partidas::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Contabilidad\Ctb_documentos_partidas  $ctb_documentos_partidas
     * @return \Illuminate\Http\Response
     */
    public function show(Ctb_documentos_partidas $ctb_documentos_partidas) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Contabilidad\Ctb_documentos_partidas  $ctb_documentos_partidas
     * @return \Illuminate\Http\Response
     */
    public function edit(Ctb_documentos_partidas $ctb_documentos_partidas) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Contabilidad\Ctb_documentos_partidas  $ctb_documentos_partidas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'num_partida' => 'required|max:10',
            'id_conceptofinanciero' => 'required|max:20',
            'descripcion_complementaria' => 'required|max:255',
            'cantidad' => 'required|max:19',
            'cve_unidad_medida' => 'required|max:7',
            'precio_unitario' => 'required|max:13',
            'porcentaje_impuesto' => 'required|max:13',
            'porcentaje_descuento' => 'required|max:13',
            'subtotal' => 'required|max:13',
            'total_partida' => 'required|max:13',
        ]);
        $edit = Ctb_documentos_partidas::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Contabilidad\Ctb_documentos_partidas  $ctb_documentos_partidas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        Ctb_documentos_partidas::find($id)->delete();
        return response()->json(['done']);
    }

}
