<?php

namespace App\Http\Controllers\autentificacion;

use App\Models\autentificacion\login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class loginController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('autentificacion/login');
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
                    'Cve_usuario' => 'required|max:100',
                    'Password' => 'required|max:15|min:4',
        ]);
  
        if ($validator->fails()) {
            return redirect('autentificacion/login')
                            ->withErrors($validator)
                            ->withInput($request->except('Password'));
        } else {
            $v = login::login($request->all());
            if (!isset($v)) {
                return redirect('autentificacion/login')
                                ->withInput();
            } else {
                $this->session_login($request, $v);
                return redirect('/inicio');
            }
        }
        
    }
    
    public function logout(Request $request) {
        $request->session()->flush('key') ;
        return redirect('autentificacion/login');
    }

    public function session_login(Request $request, $v) {
//        Crear variable de session
        $request->session()->put('key', $v);
        
//        Imprimir variable de session
//        $value = $request->session()->get('key');
//        Borrar variable de session
//        $request->session()->flush() ;
    }

}
