<?php

namespace App\Http\Controllers\compras;

use App\Models\compras\cmp_solicitud_pago;
use App\Models\contabilidad\ctb_solicitudpago_encabezado;
use App\Models\contabilidad\ctb_solicitudpago_partidas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;


class cmp_solicitud_pagoController extends Controller {

    #Funcion para enlistar los tipos de centro costo (tabla ctb_tipos_centro_costo) haciendo referencia a los campos cve_tipoCentroCosto(pk) y tipo_cc(descripcion)
    public function listar() {

        $data['ctb_tipos_centros_costo'] = DB::table('ctb_tipos_centros_costo')
        ->select('cve_tipoCentroCosto','tipo_cc')
        ->orderBy('tipo_cc')
        ->get();
        return view('compras/cmp_solicitud_pago/index', ['data' => $data]);
    }

    #Funcion para extraer de la BD la informacion para el select2 que se encuentra en la vista compras/cmp_solicitud_pago/index -> beneficiarios
    public function get_beneficiarios() {
        $create = DB::table('ctb_cat_centros_costo')
        ->orderBy('nombre_centrocosto')
        ->select('id_centrocosto','nombre_centrocosto')
        ->get();
        return response()->json($create);
    }

    #Funcion para extraer de la BD la informacion para el select2 que se encuentra en la vista compras/cmp_solicitud_pago/index -> conceptos
    public function get_conceptos() {
        $values = DB::table('ctb_cat_concepto_financiero')
        ->orderBy('nombre_concepto')
        ->select('id_conceptofinanciero','nombre_concepto')
        ->get();
        $create = array();
        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->id_conceptofinanciero, 'label' => $fila->nombre_concepto));  
        }
        return response()->json($create);
    }

    #Funcion para almacenar
    public function store(Request $request) {
        # se obtiene la fecha actual con la hora actual
        $hoy=Carbon::now();
        $id_solicitudpago = DB::table('ctb_solicitudpago_encabezado')->where('cve_compania', '019')->max('id_solicitudpago');
        //dd($request->all());
        $create = ctb_solicitudpago_encabezado::create(array_merge($request->all(), [
                        'cve_compania' => $request->input('cve_compania'),
                        'id_solicitudpago' => ($id_solicitudpago)? $id_solicitudpago+1:1,
                        'fecha_registro' => $hoy,
                        'cve_moneda' => $request->input('cve_moneda'),
                        'tipo_orden' => $request->input('tipo_orden'),
                        'id_centrocosto' => $request->input('id_centrocosto'),
                        'cve_usuario_genero' => $request->input('cve_usuario_genero'),
                        'cve_usuario_autorizo' => '',
                        'comentarios' => $request->input('comentarios'),
                        'id_tipo_cambio' => $request->input('id_tipo_cambio'),
                        'estatus' => $request->input('estatus'),
                        'importe_solicitado' => $request->input('importe_solicitado'),
                        'importe_depositado' => 0.00,
            ]));
        $id_solicitudpago_max = DB::table('ctb_solicitudpago_encabezado')->where('cve_compania', '019')->max('id_solicitudpago');

        echo $id_solicitudpago_max;
    }

    public function storePartidas(Request $request){
        $rule = array();
        $request2=$request->input();
        $longitud_array=count($request2);
        /*foreach ($request2 as $key=>$fila){
            $rule['descripcion_adicional']='numeric';
            print_r($fila);
            $validator = Validator::make($fila, $rule);
            if ($validator->validate()) {
                return response()->json($validator->fails());
            }
        }*/
        print_r($request2);
        $validator = Validator::make($request2, [
            '*.importe_concepto'=>'numeric',
            '*.descripcion_adicional'=>'max:255'
            ]);
        if ($validator->validate()) {
            return response()->json($validator->fails());
        }else{

        }
    }

}
