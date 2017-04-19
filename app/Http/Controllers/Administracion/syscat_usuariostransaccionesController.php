<?php

namespace App\Http\Controllers\Administracion;

use App\Models\Administracion\Syscat_usuariostransacciones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class syscat_usuariostransaccionesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $cve_usuario) {
//compañia agregar la variable de session
        $data['syscat_roles'] = DB::table('SYSCAT_ROLES')->where('SYSCAT_ROLES.cve_compania', '019')->get()->toArray();
        $data['syscat_usuarios'] = DB::table('SYSCAT_USUARIOS')->select('Cve_usuario', 'Nombre')->where('Cve_usuario', $cve_usuario)->first();
        $data['syscat_transacciones'] = DB::table('SYSCAT_TRANSACCIONES')->get()->toArray();
        $data['syscat_usuariostransacciones_array'] = DB::table('SYSCAT_USUARIOSTRANSACCIONES')->select('Cve_transaccion')->where('Cve_usuario', $cve_usuario)->get()->toArray();

        $data['syscat_usuariostransacciones'] = array(0 => '');
        foreach ($data['syscat_usuariostransacciones_array'] as $fila) {
            array_push($data['syscat_usuariostransacciones'], $fila->Cve_transaccion);
        }

        foreach ($data['syscat_roles'] as $file) {
            $file->Cve_transaccion = DB::table('SYSCAT_ROLESTRANSACCIONES')->select('Cve_transaccion')->where('Nombre_roll', $file->Nombre_roll)->get()->toArray();
            $file_2 = array();
            foreach ($file->Cve_transaccion as $value) {
                array_push($file_2, "'" . $value->Cve_transaccion . "'" . ":'1'");
            }
            $file->Cve_transaccion = $file_2;
        }
//        echo '<pre>';
//        echo implode( ',',  $data['syscat_roles'][0]->Cve_transaccion);
//        echo '</pre>';

        return view('Administracion.syscat_usuariostransacciones.index', ['data' => $data]);
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

        if ($request->input('con_perfil') == 'si') {
            $this->validate($request, [
                'Nombre_roll' => 'required|max:30',
            ]);
//compañia agregar la variable de session
            DB::table('SYSCAT_ROLES')->insert(array('Nombre_roll' => $request->input('Nombre_roll'), 'cve_compania' => '1'));

            if (is_array($request->input('Cve_transaccion')) || is_object($request->input('Cve_transaccion'))) {
                $data2['Nombre_roll'] = $request->input('Nombre_roll');
                foreach ($request->input('Cve_transaccion') as $fila) {
                    $data2['Cve_transaccion'] = str_replace("_", ".", $fila);
//                    Syscat_usuariostransacciones::create($data);
                    DB::table('syscat_rolestransacciones')->insert($data2);
                }
            }
        }


        DB::table('SYSCAT_USUARIOSTRANSACCIONES')->where('Cve_usuario', $request->input('Cve_usuario'))->delete();

        $data['Cve_usuario'] = $request->input('Cve_usuario');
        //compañia agregar la variable de session
        $data['cve_compania'] = 1;
        if (is_array($request->input('Cve_transaccion')) || is_object($request->input('Cve_transaccion'))) {
            foreach ($request->input('Cve_transaccion') as $fila) {
                $data['Cve_transaccion'] = str_replace("_", ".", $fila);
                Syscat_usuariostransacciones::create($data);
            }
        }

        return redirect('autentificacion/usuarios');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Administracion\syscat_usuariostransacciones  $syscat_usuariostransacciones
     * @return \Illuminate\Http\Response
     */
    public function show(syscat_usuariostransacciones $syscat_usuariostransacciones) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Administracion\syscat_usuariostransacciones  $syscat_usuariostransacciones
     * @return \Illuminate\Http\Response
     */
    public function edit(syscat_usuariostransacciones $syscat_usuariostransacciones) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Administracion\syscat_usuariostransacciones  $syscat_usuariostransacciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, syscat_usuariostransacciones $syscat_usuariostransacciones) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Administracion\syscat_usuariostransacciones  $syscat_usuariostransacciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(syscat_usuariostransacciones $syscat_usuariostransacciones) {
        //
    }

}
