<?php

namespace App\Http\Controllers\compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
}
