<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_tipo_contrato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
#importamos los modelos necesarios
use App\Models\nomina\nmn_sat_tipoJornada;
use App\Models\nomina\nmn_sat_tipoContrato;

class nmn_cat_tipo_contratoController extends Controller
{
    public function index()
    {
        $items = nmn_cat_tipo_contrato::paginate(6);

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

    public function listar() {
        return view('nomina/nmn_cat_tipo_contrato/index');
    }

    #funciones para rellenar los <select> de la vista de nmn_tipo_contrato

    public function getTipoContrato()
    {
        $tiposContrato = nmn_sat_tipoContrato::all()->toArray();
        return view('nomina/nmn_cat_tipo_contrato/index')->with('tiposContrato',$tiposContrato);
    }
    public function getTipoJornada()
    {
        $tiposJornada = nmn_sat_tipoJornada::all()->toArray();
        return view('nomina/nmn_cat_tipo_contrato/index')->with('tiposJornada',$tiposJornada);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(nmn_cat_tipo_contrato $nmn_cat_tipo_contrato)
    {
        //
    }

    public function edit(nmn_cat_tipo_contrato $nmn_cat_tipo_contrato)
    {
        //
    }

    public function update(Request $request, nmn_cat_tipo_contrato $nmn_cat_tipo_contrato)
    {
        //
    }

    public function destroy(nmn_cat_tipo_contrato $nmn_cat_tipo_contrato)
    {
        //
    }
}
