<?php

namespace App\Http\Controllers\compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\compras\cmp_ordenescompra_encabezado;
use App\Models\compras\cmp_ordenescompra_partidas;

class cmp_orden_compraController extends Controller
{
   public function indice(){
   		return view('compras/cmp_ordenescompra/index');
   } 

   public function getProducts(){
   		$values = DB::table('inv_cat_productos')
   		->join('inv_productos_GTIN','inv_cat_productos.cve_cat_producto','=','inv_productos_GTIN.cve_cat_producto')
   		->join('glx_unidades_medida','inv_productos_GTIN.cve_unidad_medida','=','glx_unidades_medida.cve_unidad_medida')
        ->select('inv_productos_GTIN.folio_gtin as fol_gtin', 'inv_cat_productos.nombre_producto as n_prod', 'inv_productos_GTIN.cve_unidad_medida as medida', 'glx_unidades_medida.nom_unidad_medida as medida_label','inv_productos_GTIN.precio_unitario as pu')
        ->where('inv_productos_GTIN.estatus','=','A')
        ->get();

        $create=array();
        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->fol_gtin, 'label' => strtoupper($fila->n_prod).' precio:$'.$fila->pu, 'cve_medida' => $fila->medida, 'cve_medida_label' => $fila->medida_label));
        }

        return response()->json($create);
   }

   # funcion que almacena el encabezado de la orden de compra
   public function storeEncabezado(Request $request){
        # se obtiene la fecha actual con la hora actual
        $hoy=Carbon::now();
        $num_orden = DB::table('cmp_ordenescompra_encabezado')->where('cve_compania', '019')->max('num_orden');
        $create = cmp_ordenescompra_encabezado::create(array_merge($request->all(), [
                        'cve_compania' => $request->input('cve_compania'),
                        'num_orden' => ($num_orden)? $num_orden+1:1,
                        'id_proveedor' => $request->input('id_proveedor'),
                        'fecha_registro' => $hoy,
                        #'fecha_entrega' => '',
                        'usuario_registra' => '',                        
                        'usuario_solicita' => '',
                        'usuario_autoriza' => '',
                        'uruario_represente_legal' => '',
                        'comentarios' => $request->input('comentarios'),
                        'lugar_entrega' => $request->input('lugar_entrega'),
                        'condiciones_entrega' => $request->input('condiciones_entrega'),
                        'condiciones_pago' => $request->input('condiciones_pago'),
                        'cve_moneda' => $request->input('cve_moneda'),
                        'tipo_cambio' => $request->input('tipo_cambio'),
                        'estatus' => 'A',
        ]));
        $num_orden_max = DB::table('cmp_ordenescompra_encabezado')->where('cve_compania', '019')->max('num_orden');
        $response=($num_orden_max)?$num_orden_max:-404;
        sleep(3.5);
        echo $response;
   }

   # funcion que almacena las partidas de la orden de compra
   public function storePartidas(Request $request){

        $data = array();
        $request2=$request->input();
        $longitud_array=count($request2);
        $num_solicitud="";
        foreach ($request2 as $key=>$fila){
            $data[$key]['cve_compania']=$fila['cve_compania'];
            $data[$key]['num_orden']=$fila['num_orden'];
            $data[$key]['num_partida']=$fila['num_partida'];
            $data[$key]['folio_GTIN']=$fila['id_concepto_financiero'];
            $data[$key]['descripcion_adicional']=$fila['descripcion_adicional'];
            $data[$key]['importe_concepto']=$fila['importe_concepto'];
            $num_solicitud=$fila['id_solicitudpago'];
        }
        //print_r($request2);
        $validator = Validator::make($request2, [
            '*.importe_concepto'=>'numeric',
            '*.descripcion_adicional'=>'max:255'
            ]);
        if ($validator->validate()) {
            return response()->json($validator->fails());
        }else{
            //$create = ctb_solicitudpago_partidas::create
            $r= DB::table('ctb_solicitudpago_partidas')->insert($data);
            $respuesta=($r)?$num_solicitud:-404;
            echo $respuesta;
        }
   }



}
