<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_empleados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class nmn_cat_empleadosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = nmn_cat_empleados::paginate(6);

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
        return view('nomina/nmn_cat_empleados/index');
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
            'num_empleado' => 'required|max:20',
            'nombre_empleado' => 'required|max:50',
            'primer_apellido' => 'required|max:50',
            'segundo_apellido' => 'required|max:50',
            'codigo_pais' => 'required|max:11',
            'cve_entidad' => 'required|max:11',
            'cve_municipio' => 'required|max:11',
            'cve_localidad' => 'required|max:11',
            'asentamiento' => 'required|max:60',
            'calle_domicilio' => 'required|max:60',
            'num_exterior' => 'required|max:15',
            'num_interior' => 'required|max:15',
            'telefono_casa' => 'required|max:10',
            'telefono_celular' => 'required|max:10',
            'telefono_otro' => 'required|max:10',
            'correo_electronico' => 'required|max:35',
            'rfc' => 'required|max:13',
            'curp' => 'required|max:18',
            'numero_seguro_social' => 'required|max:11',
            'id_centrocosto' => 'required|max:20',
            'cve_banco' => 'required|max:3',
            'cuenta_bancaria' => 'required|max:18',
        ]);

        $create = nmn_cat_empleados::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function show(nmn_cat_empleados $nmn_cat_empleados) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function edit(nmn_cat_empleados $nmn_cat_empleados) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'cve_compania' => 'required|max:3',
            'num_empleado' => 'required|max:20',
            'nombre_empleado' => 'required|max:50',
            'primer_apellido' => 'required|max:50',
            'segundo_apellido' => 'required|max:50',
            'codigo_pais' => 'required|max:11',
            'cve_entidad' => 'required|max:11',
            'cve_municipio' => 'required|max:11',
            'cve_localidad' => 'required|max:11',
            'asentamiento' => 'required|max:60',
            'calle_domicilio' => 'required|max:60',
            'num_exterior' => 'required|max:15',
            'num_interior' => 'required|max:15',
            'telefono_casa' => 'required|max:10',
            'telefono_celular' => 'required|max:10',
            'telefono_otro' => 'required|max:10',
            'correo_electronico' => 'required|max:35',
            'rfc' => 'required|max:13',
            'curp' => 'required|max:18',
            'numero_seguro_social' => 'required|max:11',
            'id_centrocosto' => 'required|max:20',
            'cve_banco' => 'required|max:3',
            'cuenta_bancaria' => 'required|max:18',
        ]);
        $edit = nmn_cat_empleados::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        nmn_cat_empleados::find($id)->delete();
        return response()->json(['done']);
    }

}
