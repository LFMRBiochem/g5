<?php

namespace App\Http\Controllers\inventario;

use App\Models\inventario\inv_cat_productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class inv_cat_productosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = inv_cat_productos::paginate(6);

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
        return view('inventario/inv_cat_productos/index');
    }

    public function get_unidad_medida($cve_unidad_medida) {
        $create = DB::table('glx_unidades_medida')
                ->where('cve_unidad_medida', $cve_unidad_medida)
                ->select('nom_unidad_medida', 'cve_unidad_medida')
                ->first();

        return response()->json($create);
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

    public function get_nombre_segmento($cve_segmento) {
        $segemento = DB::table('inv_productos_segmento')
                ->where('cve_segmento', $cve_segmento)
                ->first();
        return response()->json($segemento);
    }

    public function get_nombre_familia($segmento, $cve_familia) {
        $familia = DB::table('inv_productos_familia')
                ->where('cve_familia', $cve_familia)
                ->where('cve_segmento', $segmento)
                ->first();
        return response()->json($familia);
    }

    public function get_nombre_clase($segmento, $familia, $cve_clase) {
        $clase = DB::table('inv_productos_clase')
                ->where('cve_clase', $cve_clase)
                ->where('cve_segmento', $segmento)
                ->where('cve_familia', $familia)
                ->first();
        return response()->json($clase);
    }

    public function get_nombre_bloque($segmento, $familia, $clase, $cve_bloque) {
        $bloque = DB::table('inv_productos_bloque')
                ->where('cve_bloque', $cve_bloque)
                ->where('cve_segmento', $segmento)
                ->where('cve_familia', $familia)
                ->where('cve_clase', $clase)
                ->first();
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

    function get_productos_edit($cve_cat_producto) {
        $create = DB::table('inv_cat_productos')
                ->join('inv_productos_GTIN', 'inv_cat_productos.cve_cat_producto', '=', 'inv_productos_GTIN.cve_cat_producto')
                ->where('inv_cat_productos.cve_cat_producto', $cve_cat_producto)
                ->get()
                ->toArray();

        return response()->json($create);
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

        $rule = array();
        $rule['guardar'] = 'required';
        $rule['cve_producto'] = 'required|max:8';
        $rule['nombre_producto'] = 'required|max:150';
        $rule['usos'] = 'required|max:150';
        $rule['dosis'] = 'required|max:255';
        $rule['ventajas'] = '';
        $rule['formula'] = '';

        for ($i = 1; $i <= $request->input('contador'); $i++) {
            if ($request->input('guardar.' . $i) == 1) {
                $rule['gtin.' . $i] = 'required|max:12';
                $rule['precio_unitario.' . $i] = 'required|max:15';
                $rule['piezas_por_paquete.' . $i] = 'required|max:11';
                $rule['venta_minima.' . $i] = 'required|max:11';
                $rule['peso_unitario.' . $i] = 'required|max:17';

                $rule['cve_unidad_medida.' . $i . '.value'] = 'required|max:8';
            }
        }

        $validator = Validator::make($request->all(), $rule);
        if ($validator->validate()) {
            return response()->json($validator->fails());
        }

        for ($i = 1; $i <= $request->input('contador'); $i++) {
            if ($request->input('guardar.' . $i) == 1) {
                $rule2['piezas_por_paquete.' . $i] = 'numeric';
                $rule2['venta_minima.' . $i] = 'numeric';
                $rule2['precio_unitario.' . $i] = 'numeric';
                $rule2['peso_unitario.' . $i] = 'numeric';
            }
        }

        $v = Validator::make($request->all(), $rule2);
        if ($v->validate()) {
            return response()->json($v->fails());
        } else {
            $id = DB::table('inv_cat_productos')->insertGetId(
                    array(
                        'cve_compania' => '019',
                        'cve_producto' => $request->input('cve_producto'),
                        'nombre_producto' => $request->input('nombre_producto'),
                        'usos' => $request->input('usos'),
                        'dosis' => $request->input('dosis'),
                        'ventajas' => $request->input('ventajas'),
                        'formula' => $request->input('formula'),
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                    )
            );

            for ($i = 1; $i <= $request->input('contador'); $i++) {
                $data = array();
                if ($request->input('guardar.' . $i) == 1) {
                    $data['cve_cat_producto'] = $id;
                    $data['gtin'] = $request->input('gtin.' . $i);
                    $data['precio_unitario'] = $request->input('precio_unitario.' . $i);
                    $data['piezas_por_paquete'] = $request->input('piezas_por_paquete.' . $i);
                    $data['venta_minima'] = $request->input('venta_minima.' . $i);
                    $data['es_venta'] = $request->input('es_venta.' . $i);
                    $data['considerar_margen'] = $request->input('considerar_margen.' . $i);
                    $data['peso_unitario'] = $request->input('peso_unitario.' . $i);
                    $data['cve_unidad_medida'] = $request->input('cve_unidad_medida.' . $i . '.value');
                    $data['estatus'] = 'A';
                }
                DB::table('inv_productos_GTIN')->insert($data);
            }
        }
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
    public function update(Request $request, $id) {

        $rule = array();
        $rule['guardar'] = 'required';
        $rule['cve_producto'] = 'required|max:8';
        $rule['nombre_producto'] = 'required|max:150';
        $rule['usos'] = 'required|max:150';
        $rule['dosis'] = 'required|max:255';
        $rule['ventajas'] = '';
        $rule['formula'] = '';

        for ($i = 1; $i <= $request->input('contador'); $i++) {
            if ($request->input('guardar.' . $i) == 1) {
                $rule['gtin.' . $i] = 'required|max:12';
                $rule['precio_unitario.' . $i] = 'required|max:15';
                $rule['piezas_por_paquete.' . $i] = 'required|max:11';
                $rule['venta_minima.' . $i] = 'required|max:11';
                $rule['peso_unitario.' . $i] = 'required|max:17';

                $rule['cve_unidad_medida.' . $i . '.value'] = 'required|max:8';
            }
        }

        $validator = Validator::make($request->all(), $rule);
        if ($validator->validate()) {
            return response()->json($validator->fails());
        }

        for ($i = 1; $i <= $request->input('contador'); $i++) {
            if ($request->input('guardar.' . $i) == 1) {
                $rule2['piezas_por_paquete.' . $i] = 'numeric';
                $rule2['venta_minima.' . $i] = 'numeric';
                $rule2['precio_unitario.' . $i] = 'numeric';
                $rule2['peso_unitario.' . $i] = 'numeric';
            }
        }

        $v = Validator::make($request->all(), $rule2);
        if ($v->validate()) {
            return response()->json($v->fails());
        } else {

            DB::table('inv_cat_productos')
                    ->where('cve_cat_producto', $id)
                    ->update(
                            array(
                                'cve_compania' => '019',
                                'cve_producto' => $request->input('cve_producto'),
                                'nombre_producto' => $request->input('nombre_producto'),
                                'usos' => $request->input('usos'),
                                'dosis' => $request->input('dosis'),
                                'ventajas' => $request->input('ventajas'),
                                'formula' => $request->input('formula'),
                            )
            );

            for ($i = 1; $i <= $request->input('contador'); $i++) {
                $data = array();

                if ($request->input('guardar.' . $i) == 1) {
                    $data['cve_cat_producto'] = $id;
                    $data['gtin'] = $request->input('gtin.' . $i);
                    $data['precio_unitario'] = $request->input('precio_unitario.' . $i);
                    $data['piezas_por_paquete'] = $request->input('piezas_por_paquete.' . $i);
                    $data['venta_minima'] = $request->input('venta_minima.' . $i);
                    $data['es_venta'] = $request->input('es_venta.' . $i);
                    $data['considerar_margen'] = $request->input('considerar_margen.' . $i);
                    $data['peso_unitario'] = $request->input('peso_unitario.' . $i);
                    $data['cve_unidad_medida'] = $request->input('cve_unidad_medida.' . $i . '.value');
                    $data['estatus'] = ($request->input('estatus.' . $i) == 1) ? 'A' : 'X';

                    if ($request->input('folio_GTIN.' . $i) > '1') {
                        
                        DB::table('inv_productos_GTIN')
                                ->where('folio_GTIN', $request->input('folio_GTIN.' . $i))
                                ->update($data);
                    }
                    if ($request->input('folio_GTIN.' . $i) == 'no') {
                        DB::table('inv_productos_GTIN')->insert($data);
                    }
                }
            }
        }
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
