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
            'descripcion' => 'required|min:4|max:90',
            'percepcion_deduccion' => 'required',
            'operacion' => 'min:0',
            'id_conceptofinanciero' => 'required',
            'considerar_recibo' => 'required',
            'considerar_reportes' => 'required',
            'estatus' => 'required',
        ]);  
        $id_concepto = $request->input('id_concepto');
        $es_numero = is_numeric($id_concepto);
        $id_concepto_financiero=null;
        $id_concept=0;
        if($es_numero==false){
            //Obtener el maximo numero del concepto financiero
            $id_concepto_financiero = ctb_cat_concepto_financiero::getConceptoFinanciero();
            $ecsplode=explode(".",$id_concepto_financiero);
            $id_concept=intval($ecsplode[1]);
            $id_concept+=1;
            $id_concepto_financiero="601.".$id_concept;

            $id_concepto_financiero_nuevo = ctb_cat_concepto_financiero::insert_concepto_financiero(array(
                'cve_compania' => $request->input('id_concepto'),
                'cve_concepto_financiero' => $id_concepto_financiero,
                'catalogo_sat' => $id_concepto_financiero,
                'nombre_concepto' => $request->input('descripcion'),
                'naturaleza' => 'D',
                'nmn' => '1',
                'status' => $request->input('estatus'))
            );
            $create = nmn_cat_conceptos::create(array_merge($request->all(), [
                        'cve_compania' => $request->input('cve_compania'),
                        'id_concepto' => $id_concept,
                        'descripcion' => $request->input('descripcion'),
                        'percepcion_deduccion' => $request->input('percepcion_deduccion'),
                        'operacion' => $request->input('operacion'),
                        'id_conceptofinanciero' => $id_concepto_financiero,
                        'considerar_recibo' => $request->input('considerar_recibo'),
                        'considerar_reportes' => $request->input('considerar_reportes'),
                        'estatus' => $request->input('estatus'),
            ]));
            
        }else{
            $create = nmn_cat_conceptos::create(array_merge($request->all(), [
                        'cve_compania' => $request->input('cve_compania'),
                        'id_concepto' => $request->input('id_concepto'),
                        'descripcion' => $request->input('descripcion'),
                        'percepcion_deduccion' => $request->input('percepcion_deduccion'),
                        'operacion' => $request->input('operacion'),
                        'id_conceptofinanciero' => $request->input('id_conceptofinanciero'),
                        'considerar_recibo' => $request->input('considerar_recibo'),
                        'considerar_reportes' => $request->input('considerar_reportes'),
                        'estatus' => $request->input('estatus'),
            ]));
        }

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
            'descripcion' => 'required|min:4|max:90',
            'percepcion_deduccion' => 'required',
            'operacion' => 'min:0',
            'id_conceptofinanciero' => 'required',
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
