<?php

namespace App\Http\Controllers\contabilidad;

use App\Models\contabilidad\Ctb_reservacfdi_impuestos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ctb_reservacfdi_impuestosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //

        $items = Ctb_reservacfdi_impuestos::paginate(6);

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
        $data['ctb_reserva_cfdi'] = DB::table('ctb_reserva_cfdi')->select('id_reserva')->get();
        return view('contabilidad/ctb_reservacfdi_impuestos/index', ['data' => $data]);
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
            'id_reserva' => 'required|max:20',
            'descripcion' => 'required|max:20',
            'porcentaje' => 'required|max:5',
            'impuesto' => 'required|max:13',
        ]);

        $create = Ctb_reservacfdi_impuestos::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\contabilidad\Ctb_reservacfdi_impuestos  $ctb_reservacfdi_impuestos
     * @return \Illuminate\Http\Response
     */
    public function show(Ctb_reservacfdi_impuestos $ctb_reservacfdi_impuestos) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\contabilidad\Ctb_reservacfdi_impuestos  $ctb_reservacfdi_impuestos
     * @return \Illuminate\Http\Response
     */
    public function edit(Ctb_reservacfdi_impuestos $ctb_reservacfdi_impuestos) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\contabilidad\Ctb_reservacfdi_impuestos  $ctb_reservacfdi_impuestos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'id_reserva' => 'required|max:20',
            'descripcion' => 'required|max:20',
            'porcentaje' => 'required|max:5',
            'impuesto' => 'required|max:13|numeric',
        ]);
        $edit = Ctb_reservacfdi_impuestos::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\contabilidad\Ctb_reservacfdi_impuestos  $ctb_reservacfdi_impuestos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ctb_reservacfdi_impuestos $ctb_reservacfdi_impuestos) {
        //
    }

}
