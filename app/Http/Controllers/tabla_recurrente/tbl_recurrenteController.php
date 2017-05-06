<?php

namespace App\Http\Controllers\tabla_recurrente;

use App\Model\tabla_recurrente\tbl_recurrente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class tbl_recurrenteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function get_entidad() {
        $create = DB::table('dgis_CAT_ENTIDADES')
                ->select('Cve_entidad as value', 'Estado as label')
                ->get();
        return response()->json($create);
    }

    public function get_municipio($Cve_entidad) {
        $create = DB::table('dgis_CAT_MUNICIPIOS')
                ->where('Cve_entidad', $Cve_entidad)
                ->orderBy('Nom_municipio')
                ->select('Nom_municipio as label', 'Cve_municipio as value')
                ->get();

        return response()->json($create);
    }

    public function get_localidad($Cve_municipio, $Cve_entidad) {
        $create = DB::table('dgis_CAT_LOCALIDADES')
                ->where('Cve_municipio', $Cve_municipio)
                ->where('Cve_entidad', $Cve_entidad)
                ->orderBy('Nom_localidad')
                ->select('Nom_localidad as label', 'Cve_localidad as value')
                ->get();

        return response()->json($create);
    }

    public function get_banco() {
        $create = DB::table('ctb_cat_bancos')
                ->orderBy('nom_corto_banco')
                ->select('nom_corto_banco as label', 'id_banco as value')
                ->get();

        return response()->json($create);
    }

    public function get_sat_banco() {
        $create = DB::table('ctb_cat_bancos')
                ->orderBy('nom_corto_banco')
                ->select('nom_corto_banco as label', 'cve_banco as value')
                ->get();

        return response()->json($create);
    }

    public function get_codigo_postal($Cve_municipio, $entidad) {
        $values = DB::table('dgis_CODIGO_POSTAL')
                ->where([
                    ['Cve_municipio', $Cve_municipio],
                    ['Cve_estado', $entidad],])
                ->select('Codigo_postal', 'Asentamiento', 'Tipo_asentamiento')
                ->get();

        $create = array();
        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->Codigo_postal . '|' . $fila->Tipo_asentamiento . '|' . $fila->Asentamiento, 'label' => '[' . $fila->Codigo_postal . '] ' . $fila->Tipo_asentamiento . ', ' . $fila->Asentamiento));
        }
        return response()->json($create);
    }

    public function get_razon_social() {
        $values = DB::table('ctb_cat_centros_costo')
                ->select('nombre_centrocosto')
                ->get();

        $create = array();
        foreach ($values as $fila) {

            array_push($create, array('value' => $fila->nombre_centrocosto, 'label' => str_replace("|", " ", $fila->nombre_centrocosto)));
        }
        return response()->json($create);
    }

    public function get_id_centrocosto() {
        $values = DB::table('ctb_cat_centros_costo')
                ->select('nombre_centrocosto', 'id_centrocosto as cve_compania')
                ->get();

        $create = array();
        foreach ($values as $fila) {
            /*$center_costo=$fila->nombre_centrocosto;
            $buscad=strpos($center_costo,'|');
            $ecsplode=explode('|', $center_costo);
            $first_name=$ecsplode[0];
            if($first_name!='' || empty($first_name) || $first_name==null){
                $last_name=$ecsplode[1];
                $name=$ecsplode[2];
                array_push($create, array('value' => $fila->cve_compania.'@'.$fila->nombre_centrocosto, 'label' => $name.' '.$first_name.' '.$last_name));
            }else{*/
                array_push($create, array('value' => $fila->cve_compania.'@'.$fila->nombre_centrocosto, 'label' => str_replace("|", " ",$fila->nombre_centrocosto)));  
           // }

        }
        return response()->json($create);
    }
    
    public function get_unidad_medida() {
        $create = DB::table('glx_unidades_medida')
                ->orderBy('nom_unidad_medida')
                ->select('nom_unidad_medida as label', 'cve_unidad_medida as value')
                ->get();

        return response()->json($create);
    }

    /*public function get_id_centrocosto_empleados(){
        $values = DB::table('ctb_cat_centros_costo')
                ->join('ctb_cctipos_asociaciones','ctb_cat_centros_costo.id_centrocosto','=','ctb_cctipos_asociaciones.id_centrocosto')
                ->select('ctb_cat_centros_costo.nombre_centrocosto as valt', 'ctb_cat_centros_costo.nombre_centrocosto as lab')
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto','=','CMF')
                ->get();

        $create = array();
        foreach ($values as $fila) {

            array_push($create, array('value' => $fila->valt, 'label' => str_replace("|", " ", $fila->lab)));
        }
        return response()->json($create);
    }*/

    /*public function get_id_centrocosto_empleados(){
        $values = DB::table('ctb_cat_centros_costo')
                ->join('ctb_cctipos_asociaciones','ctb_cat_centros_costo.id_centrocosto','=','ctb_cctipos_asociaciones.id_centrocosto')
                ->select('ctb_cat_centros_costo.nombre_centrocosto as valt', 'ctb_cat_centros_costo.nombre_centrocosto as lab')
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto','=','CMF')
                ->get();

        $create = array();
        foreach ($values as $fila) {

            array_push($create, array('value' => $fila->valt, 'label' => str_replace("|", " ", $fila->lab)));
        }
        return response()->json($create);
    }*/

    /*public function get_id_centrocosto_empleados(){
        $values = DB::table('ctb_cat_centros_costo')
                ->join('ctb_cctipos_asociaciones','ctb_cat_centros_costo.id_centrocosto','=','ctb_cctipos_asociaciones.id_centrocosto')
                ->select('ctb_cat_centros_costo.nombre_centrocosto as valt', 'ctb_cat_centros_costo.nombre_centrocosto as lab')
                ->where('ctb_cctipos_asociaciones.cve_tipoCentroCosto','=','CMF')
                ->get();

        $create = array();
        foreach ($values as $fila) {

            array_push($create, array('value' => $fila->valt, 'label' => str_replace("|", " ", $fila->lab)));
        }
        return response()->json($create);
    }*/

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
     * @param  \App\Model\tabla_recurrente\tbl_recurrente  $tbl_recurrente
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_recurrente $tbl_recurrente) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\tabla_recurrente\tbl_recurrente  $tbl_recurrente
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_recurrente $tbl_recurrente) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\tabla_recurrente\tbl_recurrente  $tbl_recurrente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_recurrente $tbl_recurrente) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\tabla_recurrente\tbl_recurrente  $tbl_recurrente
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_recurrente $tbl_recurrente) {
        //
    }

}
