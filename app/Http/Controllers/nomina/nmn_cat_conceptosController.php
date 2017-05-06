<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_conceptos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class nmn_cat_conceptosController extends Controller
{

    public function index()
    {
        $items = nmn_cat_conceptos::paginate(6);

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

    function get_conceptos_edit($id_concepto) {
        $create = nmn_cat_conceptos::get_conceptos_edit($id_concepto);
        return response()->json($create);
    }

    public function listar() {
        return view('nomina/nmn_cat_conceptos/index');
    }

    public function getConceptos(){
        $values = DB::table('ctb_cat_concepto_financiero')
                ->where([
                    ['nmn', '1'],
                    ['estatus','A'],])
                ->select('cve_concepto_financiero', 'nombre_concepto')
                ->get();

        $create = array();
        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->cve_concepto_financiero, 'label' => $fila->nombre_concepto));
        }
        return response()->json($create);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cve_compania' => 'required',
            'id_concepto' => 'required',
            'descripcion' => 'required',
            'percepcion_deduccion' => 'required',
            'considerar_recibo' => 'required',
            'considerar_reportes' => 'required',
            'estatus' => 'required',
        ]);  

        return response()->json($create);      
    }

    public function show(nmn_cat_conceptos $nmn_cat_conceptos)
    {
        
    }

    public function edit(nmn_cat_conceptos $nmn_cat_conceptos)
    {
        
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cve_compania' => 'required',
            'id_concepto' => 'required',
            'descripcion' => 'required',
            'percepcion_deduccion' => 'required',
            'considerar_recibo' => 'required',
            'considerar_reportes' => 'required',
            'estatus' => 'required',
        ]);
        $edit = nmn_cat_conceptos::find($id)->update($request->all());
        return response()->json($edit);
    }

    public function destroy($id)
    {
        //Verificamos que estatus tiene actuamente el proveedor
        $db_estatus = nmn_cat_conceptos::get_estatus(array('id_folio_concepto' => $id));

        //Cambiamos de activo(A)  a cancelado(X)
        if ($db_estatus->estatus == 'A') {
            $estatus = 'X';
            //Cambiamos de cancelado(X) a activo(A)
        } else {
            $estatus = 'A';
        }

        //Buscamos el id del proveedor y actualizamos los datos
        nmn_cat_conceptos::find($id)->update(array(
            'estatus' => $estatus
        ));

        return response()->json(['done']);
    }
}
