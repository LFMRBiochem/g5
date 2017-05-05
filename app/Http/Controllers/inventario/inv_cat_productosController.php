<?php

namespace App\Http\Controllers\inventario;

//use App\Models\inventario\inv_cat_productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inv_cat_productosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function listar() {
        return view('inventario/inv_cat_productos/index');
    }

    public function get_segmento() {
        $segemento = DB::table('inv_productos_segmento')->get()->toArray();
        return response()->json($segemento);
    }

    public function get_familia($segmento) {
        $familia = DB::table('inv_productos_familia')
                ->where('cve_segmento', $segmento)
                ->get()
                ->toArray();
        return response()->json($familia);
    }

    public function get_clase($segmento, $familia) {
        $clase = DB::table('inv_productos_clase')
                ->where('cve_segmento', $segmento)
                ->where('cve_familia', $familia)
                ->get()
                ->toArray();
        return response()->json($clase);
    }

    public function get_bloque($segmento, $familia, $clase) {
        $bloque = DB::table('inv_productos_bloque')
                ->where('cve_segmento', $segmento)
                ->where('cve_familia', $familia)
                ->where('cve_clase', $clase)
                ->get()
                ->toArray();
        return response()->json($bloque);
    }

    public function get_gtin() {
        $gtin = DB::table('inv_productos_GTIN')
                ->join('inv_cat_productos', 'inv_cat_productos.cve_cat_producto', '=', 'inv_productos_GTIN.cve_cat_producto')
                ->orderBy('nombre_producto')
                ->select('nombre_producto as label', 'nombre_producto as value')
                ->get();
        return response()->json($gtin);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\inventario\inv_cat_productos  $inv_cat_productos
     * @return \Illuminate\Http\Response
     */
    public function show(inv_cat_productos $inv_cat_productos) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\inventario\inv_cat_productos  $inv_cat_productos
     * @return \Illuminate\Http\Response
     */
    public function edit(inv_cat_productos $inv_cat_productos) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\inventario\inv_cat_productos  $inv_cat_productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, inv_cat_productos $inv_cat_productos) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\inventario\inv_cat_productos  $inv_cat_productos
     * @return \Illuminate\Http\Response
     */
    public function destroy(inv_cat_productos $inv_cat_productos) {
        //
    }

}
