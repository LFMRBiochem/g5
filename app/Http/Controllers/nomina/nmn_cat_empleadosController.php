<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_empleados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\contabilidad\ctb_cat_centros_costo;
use App\Models\contabilidad\ctb_cctipos_asociaciones;

class nmn_cat_empleadosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $items = nmn_cat_empleados::paginate(6);

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

    function get_empleados_edit($id_empleado) {
        $create = nmn_cat_empleados::get_empleados_edit($id_empleado);
        return response()->json($create);
    }

    function get_cps($entidad,$Cve_municipio,$asentamiento,$tipo_asentamiento){
        $values = DB::table('dgis_CODIGO_POSTAL')
                ->where([
                    ['Cve_municipio', $Cve_municipio],
                    ['Cve_estado', $entidad],
                    ['Asentamiento',$asentamiento],
                    ['Tipo_asentamiento',$tipo_asentamiento],])
                ->select('Codigo_postal', 'Asentamiento', 'Tipo_asentamiento')
                ->get();

        $create = array();
        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->Codigo_postal . '|' . $fila->Tipo_asentamiento . '|' . $fila->Asentamiento, 'label' => '[' . $fila->Codigo_postal . '] ' . $fila->Tipo_asentamiento . ', ' . $fila->Asentamiento));
        }
        $values = DB::table('dgis_CODIGO_POSTAL')
                ->where([
                    ['Cve_municipio', $Cve_municipio],
                    ['Cve_estado', $entidad],
                    ['Asentamiento','<>',$asentamiento],
                    ['Tipo_asentamiento','<>',$tipo_asentamiento],])
                ->select('Codigo_postal', 'Asentamiento', 'Tipo_asentamiento')
                ->get();

        foreach ($values as $fila) {
            array_push($create, array('value' => $fila->Codigo_postal . '|' . $fila->Tipo_asentamiento . '|' . $fila->Asentamiento, 'label' => '[' . $fila->Codigo_postal . '] ' . $fila->Tipo_asentamiento . ', ' . $fila->Asentamiento));
        }
        return response()->json($create);
    }

    function nmn_cat_empleados($id_empleado) {
        $create = nmn_cat_empleados::get_empleados_edit($id_empleado);
        echo '<pre>';
        print_r($create);
        echo '</pre>';
        return response()->json($create);
    }

    public function listar() {
        return view('nomina/nmn_cat_empleados/index');
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
            'nombre_empleado' => 'required|max:20',
            'primer_apellido' => 'required|max:50',
            'segundo_apellido' => 'required|max:50',
            'codigo_pais' => 'required|max:11',
            'cve_entidad' => 'required|max:11',
            'cve_municipio' => 'required|max:11',
            'cve_localidad' => 'required|max:11',
            'codigo_postal' => 'required|max:5',
            'asentamiento' => 'required|max:60',
            'tipo_asentamiento' => 'required|max:25',
            'calle_domicilio' => 'required|max:60',
            'num_exterior' => 'required|max:15',
            'num_interior' => 'required|max:15',
            'telefono_casa' => 'required|max:10',
            'telefono_celular' => 'required|max:10',
            'telefono_otro' => 'required|max:10',
            'correo_electronico' => 'required|max:35',
            'rfc' => array('required','regex:/[A-Z]{3,4}[ \-]?[0-9]{2}((0{1}[1-9]{1})|(1{1}[0-2]{1}))((0{1}[1-9]{1})|([1-2]{1}[0-9]{1})|(3{1}[0-1]{1}))[ \-]?[A-Z0-9]{3}/i'),
            'curp' => array('required','regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'),
            'numero_seguro_social' => 'required|max:11',
            'id_centrocosto' => 'required|max:20',
            'cve_banco' => 'required|max:3',
            'cuenta_bancaria' => 'required|digits:18',
        ]);
        $id_centrocosto=null;
        $is_num_centro_costo=is_numeric($request->input('id_centrocosto'));
        $center_costo=$request->input('nombre_empleado').' '.$request->input('primer_apellido').' '.$request->input('segundo_apellido');
        if($is_num_centro_costo==false){
            //Saber si existe el centro_costo
            //print_r($center_costo);
            $id_centrocosto = ctb_cat_centros_costo::get_id_centrocosto(array(
                'cve_compania' => '019',
                'nombre_centrocosto' => strtoupper($center_costo))
            );
        }
        else{
            $id_centrocosto = ctb_cat_centros_costo::get_id_centrocosto(array(
                'cve_compania' => '019',
                'id_centrocosto' => $request->input('id_centrocosto'))
            );
        }
        //Validar si existe el centro_costo en la tabla ctb_cat_centros_costo
        //Si existe el centro costo en la tabla ctb_cat_centros_costo
        if ($id_centrocosto) {

            $id_centrocosto = $id_centrocosto->id_centrocosto;
            //Obtenemos los tipo de asociacion
            $tipoCentroCosto = ctb_cctipos_asociaciones::get_cve_tipoCentroCosto(array(
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto)
            );
            $update_asociaciones=0;
            $folio_asociacion=null;
            //Verificamos que el tipo de asociacion sea CMF o CMM
            foreach ($tipoCentroCosto as $fila) {
                if ($fila->cve_tipoCentroCosto == 'NMN') {
                    //Bandera para saber si es un tipo CMF o CMM
                    $update_asociaciones = 1;
                    $folio_asociacion = $fila->folio_asociacion;
                }
            }

            // Si la cve_tipoCentroCosto contiene una de estas dos formas actualizar
            print_r($folio_asociacion);
            if ($update_asociaciones == 1) {
                //Actualizamos el tipo de Centro costo con ayuda del tipo persona insertado en el formulario
                ctb_cctipos_asociaciones::update_cve_tipoCentroCosto(array(
                    'cve_tipoCentroCosto' => 'NMN'),array(
                    'folio_asociacion' => $folio_asociacion)
                );
                // Si la cve_tipoCentroCosto contiene ninguna de las formas insertar
            } else {
                //Insertamos el tipo de centro costo en la tabla ctb_cctipos_asociaciones
                ctb_cctipos_asociaciones::insert_cve_tipoCentroCosto(array('cve_compania' => '019', 'id_centrocosto' => $id_centrocosto, 'cve_tipoCentroCosto' => 'NMN'));
            }
            //Insertamos en la tabla nmn_cat_empleados
            $num_empleado = DB::table('nmn_cat_empleados')->where('cve_compania', '019')->max('num_empleado');

            $create = nmn_cat_empleados::create(array_merge($request->all(), [
                        'num_empleado' => ($num_empleado) ? $num_empleado + 1 : 1,
                        'nombre_empleado' => strtoupper($request->input('nombre_empleado')),
                        'primer_apellido' => strtoupper($request->input('primer_apellido')),
                        'segundo_apellido' => strtoupper($request->input('segundo_apellido')),
                        'cve_compania' => '019',
                        'fecha_registro' => date('Y-m-d H:i:s'),
                        'estatus' => 'A',
                        'id_centrocosto' => $id_centrocosto,
            ]));
            //Si no existe el centro costo en la tabla ctb_cat_centros_costo
        } else {
            //Insertamos en ctb_cat_centros_costo el nombre del centro costo
            $id_centrocosto_nuevo = ctb_cat_centros_costo::insert_centro_costo(array(
                        'nombre_centrocosto' => strtoupper($request->input('nombre_empleado').'|'.$request->input('primer_apellido').'|'.$request->input('segundo_apellido')),
                        'cve_compania' => '019')
            );
            //Insertamos tipo de asociacion en la tabla ctb_cctipos_asociaciones
            ctb_cctipos_asociaciones::insert_tipos_asociaciones(array(
                'cve_compania' => '019',
                'id_centrocosto' => $id_centrocosto_nuevo,
                'cve_tipoCentroCosto' => 'NMN')
            );

            //Insertamos en la tabla nmn_cat_empleados el formulario
            $num_empleado = DB::table('nmn_cat_empleados')->where('cve_compania', '019')->max('num_empleado');

            $create = nmn_cat_empleados::create(array_merge($request->all(), [
                        'num_empleado' => ($num_empleado) ? $num_empleado + 1 : 1,
                        'nombre_empleado' => strtoupper($request->input('nombre_empleado')),
                        'primer_apellido' => strtoupper($request->input('primer_apellido')),
                        'segundo_apellido' => strtoupper($request->input('segundo_apellido')),
                        'cve_compania' => '019',
                        'fecha_registro' => date('Y-m-d H:i:s'),
                        'estatus' => 'A',
                        'id_centrocosto' => $id_centrocosto_nuevo,
            ]));
            /*$create = cmp_cat_proveedores::create(array_merge($request->all(), array(
                        //Hacemos mayusculas los datos del razon social
                        'razon_social' => strtoupper($request->input('razon_social')),
                        //Hacemos mayusculas los datos del RFC
                        'rfc' => strtoupper($request->input('rfc')),
                        'cve_compania' => '019',
                        'id_centrocosto' => $id_centrocosto_nuevo,
                        'estatus' => 'A',
            )));*/
        }
        

        echo '<pre>';
        print_r($create);
        echo '</pre>';
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function show(nmn_cat_empleados $nmn_cat_empleados) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function edit(nmn_cat_empleados $nmn_cat_empleados) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'nombre_empleado' => 'required|max:20',
            'primer_apellido' => 'required|max:50',
            'segundo_apellido' => 'required|max:50',
            'codigo_pais' => 'required|max:11',
            'cve_entidad' => 'required|max:11',
            'cve_municipio' => 'required|max:11',
            'cve_localidad' => 'required|max:11',
            'codigo_postal' => 'required|max:5',
            'asentamiento' => 'required|max:60',
            'tipo_asentamiento' => 'required|max:25',
            'calle_domicilio' => 'required|max:60',
            'num_exterior' => 'required|max:15',
            'num_interior' => 'required|max:15',
            'telefono_casa' => 'required|max:10',
            'telefono_celular' => 'required|max:10',
            'telefono_otro' => 'required|max:10',
            'correo_electronico' => 'required|max:35',
            'rfc' => array('required','regex:/[A-Z]{3,4}[ \-]?[0-9]{2}((0{1}[1-9]{1})|(1{1}[0-2]{1}))((0{1}[1-9]{1})|([1-2]{1}[0-9]{1})|(3{1}[0-1]{1}))[ \-]?[A-Z0-9]{3}/i'),
            'curp' => array('required','regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'),
            'numero_seguro_social' => 'required|max:11',
            'id_centrocosto' => 'required|max:20',
            'cve_banco' => 'required|max:3',
            'cuenta_bancaria' => 'required|digits:18',
        ]);
        $edit = nmn_cat_empleados::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\nomina\nmn_cat_empleados  $nmn_cat_empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //Verificamos que estatus tiene actuamente el proveedor
        $db_estatus = nmn_cat_empleados::get_estatus(array('id_empleado' => $id));

        //Cambiamos de activo(A)  a cancelado(X)
        if ($db_estatus->estatus == 'A') {
            $estatus = 'X';
            //Cambiamos de cancelado(X) a activo(A)
        } else {
            $estatus = 'A';
        }

        //Buscamos el id del proveedor y actualizamos los datos
        nmn_cat_empleados::find($id)->update(array(
            'estatus' => $estatus
        ));

        return response()->json(['done']);
    }

}
