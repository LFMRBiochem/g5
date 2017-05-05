<?php

namespace App\Http\Controllers\nomina;

use App\Models\nomina\nmn_cat_conceptos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class nmn_cat_conceptosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nomina\nmn_cat_conceptos  $nmn_cat_conceptos
     * @return \Illuminate\Http\Response
     */
    public function show(nmn_cat_conceptos $nmn_cat_conceptos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nomina\nmn_cat_conceptos  $nmn_cat_conceptos
     * @return \Illuminate\Http\Response
     */
    public function edit(nmn_cat_conceptos $nmn_cat_conceptos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nomina\nmn_cat_conceptos  $nmn_cat_conceptos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nmn_cat_conceptos $nmn_cat_conceptos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nomina\nmn_cat_conceptos  $nmn_cat_conceptos
     * @return \Illuminate\Http\Response
     */
    public function destroy(nmn_cat_conceptos $nmn_cat_conceptos)
    {
        //
    }
}
