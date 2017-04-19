<?php

namespace App\Http\Controllers\autentificacion;

use App\Models\autentificacion\Usuarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class usuariosController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index() {
        $items = Usuarios::paginate(6);

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
        return view('autentificacion/index');
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
            'Cve_usuario' => 'required|unique:SYSCAT_USUARIOS|max:100',
            'Nombre' => 'required|unique:SYSCAT_USUARIOS|max:100',
            'Password' => 'required|max:15|min:4',
        ]);

        $create = Usuarios::create($request->all());

        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\autentificacion\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show(Usuarios $usuarios) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\autentificacion\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuarios $usuarios) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\autentificacion\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $this->validate($request, [
            'Nombre' => 'required|max:100',
            'Password' => 'required|max:15|min:4',
        ]);
        $edit = Usuarios::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\autentificacion\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        Usuarios::find($id)->delete();
        return response()->json(['done']);
    }

}
