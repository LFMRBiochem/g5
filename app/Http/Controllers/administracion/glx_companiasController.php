<?php

namespace App\Http\Controllers\administracion;

use App\Models\administracion\glx_companias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class glx_companiasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $items = glx_companias::paginate(6);

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

    public function listar(Request $request) {
//        Crear variable de session
//        $request->session()->put('key', 'value');
//        Imprimir variable de session
//        $value = $request->session()->get('key');
//        Borrar variable de session
//        $request->session()->flush() ;
        return view('administracion/glx_companias/index');
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
            'razon_social' => 'required|max:80',
            'nombre_corto' => 'required|max:15',
            'rfc' => 'required|max:15',
            
            	
        ]);

        $create = glx_companias::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\administracion\Glx_companias  $glx_companias
     * @return \Illuminate\Http\Response
     */
    public function show(glx_companias $glx_companias) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\administracion\Glx_companias  $glx_companias
     * @return \Illuminate\Http\Response
     */
    public function edit(glx_companias $glx_companias) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\administracion\Glx_companias  $glx_companias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'razon_social' => 'required|max:80',
            'nombre_corto' => 'required|max:15',
            'rfc' => 'required|max:15',
            
        ]);
        $edit = glx_companias::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\administracion\Glx_companias  $glx_companias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        glx_companias::find($id)->delete();
        return response()->json(['done']);
    }

}
