<?php

namespace App\Http\Controllers\contabilidad;

use App\Models\contabilidad\ctb_reserva_cfdi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ctb_reserva_cfdiController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = ctb_reserva_cfdi::paginate(6);

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

        return view('contabilidad/ctb_reserva_cfdi/index');
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
            'UUID' => 'required|max:50',
            'rfc' => 'required|max:15',
            'total' => 'required|max:13',
            'nombre_proveedor' => 'required|max:150',
            'folio' => 'required|max:25',
            'subtotal' => 'required|max:13',
            'descuento' => 'required|max:13',
            'metodo_pago' => 'required|max:45',
            'cve_moneda' => 'required|max:3',
            'error_suma' => 'required|max:4',
            'descripcion' => 'required|max:255',
            'asociado' => 'required|max:4'
        ]);

        $create = ctb_reserva_cfdi::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\contabilidad\ctb_reserva_cfdi  $ctb_reserva_cfdi
     * @return \Illuminate\Http\Response
     */
    public function show(ctb_reserva_cfdi $ctb_reserva_cfdi) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\contabilidad\ctb_reserva_cfdi  $ctb_reserva_cfdi
     * @return \Illuminate\Http\Response
     */
    public function edit(ctb_reserva_cfdi $ctb_reserva_cfdi) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\contabilidad\ctb_reserva_cfdi  $ctb_reserva_cfdi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'cve_compania' => 'required|max:3',
            'UUID' => 'required|max:50',
            'rfc' => 'required|max:15',
            'total' => 'required|max:13',
            'nombre_proveedor' => 'required|max:150',
            'folio' => 'required|max:25',
            'subtotal' => 'required|max:13',
            'descuento' => 'required|max:13',
            'metodo_pago' => 'required|max:45',
            'cve_moneda' => 'required|max:3',
            'error_suma' => 'required|max:4',
            'descripcion' => 'required|max:255',
            'asociado' => 'required|max:4'
        ]);
        $edit = ctb_reserva_cfdi::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\contabilidad\ctb_reserva_cfdi  $ctb_reserva_cfdi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        ctb_reserva_cfdi::find($id)->delete();
        return response()->json(['done']);
    }

}
