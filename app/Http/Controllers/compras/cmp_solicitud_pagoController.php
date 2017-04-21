<?php

namespace App\Http\Controllers\compras;

use App\Models\compras\cmp_solicitud_pago;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class cmp_solicitud_pagoController extends Controller {

    #Funcion para enlistar los tipos de centro costo (tabla ctb_tipos_centro_costo) haciendo referencia a los campos cve_tipoCentroCosto(pk) y tipo_cc(descripcion)
    public function listar() {

        $data['ctb_tipos_centros_costo'] = DB::table('ctb_tipos_centros_costo')->select('cve_tipoCentroCosto','tipo_cc')->orderBy('tipo_cc')->get();
        return view('compras/cmp_solicitud_pago/index', ['data' => $data]);

    }

    #Funcion para extraer de la BD la informacion para el select2 que se encuentra en la vista compras/cmp_solicitud_pago/index -> beneficiarios
    public function get_beneficiarios() {
        $create = DB::table('ctb_cat_centros_costo')->orderBy('nombre_centrocosto')->select('id_centrocosto','nombre_centrocosto')->get();
        return response()->json($create);
    }

    #Funcion para extraer de la BD la informacion para el select2 que se encuentra en la vista compras/cmp_solicitud_pago/index -> conceptos
    public function get_conceptos() {
        $create = DB::table('ctb_cat_concepto_financiero')->orderBy('nombre_concepto')->select('id_conceptofinanciero','nombre_concepto')->get();
        return response()->json($create);
    }

}
