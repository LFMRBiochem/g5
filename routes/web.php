<?php

Route::get('/', function() {
    return redirect('autentificacion/login');
});

use App\Models\contabilidad\ctb_cat_concepto_financiero;

Route::get('/conceptos', function() {
    return ctb_cat_concepto_financiero::where('catalogo_sat', 'like', '105.%')->count();
});

//
# nomina ###################################
# compras ##################################
Route::group(['middleware' => ['web']], function() {
    Route::get('solicitud_pagos', 'compras\cmp_solicitud_pagoController@listar');
});

Route::get('/cmp_solicitud_pagoController/beneficiario', 'compras\cmp_solicitud_pagoController@get_beneficiarios');

Route::get('/cmp_solicitud_pagoController/conceptos', 'compras\cmp_solicitud_pagoController@get_conceptos');
# Ventas ###################################
# Inventarios ##############################
# Produccion ###############################
# Configuracion ############################
// ------------------------------------------------------------------------------

Route::get('autentificacion/login', 'autentificacion\loginController@index');
Route::post('autentificacion/logincontroller', 'autentificacion\loginController@login');
Route::get('autentificacion/logincontroller/logout', 'autentificacion\loginController@logout');



Route::group(['middleware' => 'autentificacion'], function () {

    # contabilidad #############################
    Route::get('/inicio', function () {
        return view('welcome');
    });


    Route::get('/catalogo-de-cuentas-contables', 'contabilidad\ctb_cat_cuentasController@ArbolDeCuentas');
    Route::resource('catalogo-de-cuentas-contables/crud', 'contabilidad\ctb_cat_cuentasController');

# Tesoreria ################################
# Catalogo de bancos

    Route::get('/catalogo-de-bancos', 'tesoreria\ctb_cat_bancosController@Bancos');
    Route::resource('crud-bancos', 'tesoreria\ctb_cat_bancosController');


    Route::get('/ctb_cat_monedas', 'contabilidad\ctb_cat_monedasController@listar');
    Route::resource('/ctb_cat_monedasC', 'contabilidad\ctb_cat_monedasController');


    Route::get('/ctb_cat_concepto_financiero', 'contabilidad\ctb_cat_concepto_financieroController@listar');
    Route::resource('ctb_cat_concepto_financieroC', 'contabilidad\ctb_cat_concepto_financieroController');

    Route::get('/autentificacion/usuarios', 'autentificacion\usuariosController@listar');
    Route::resource('autentificacion/usuariosC', 'autentificacion\usuariosController');

    Route::get('/nmn_sat_catbanco', 'nomina\nmn_sat_catBancoController@listar');
    Route::resource('/nmn_sat_catbancoC', 'nomina\nmn_sat_catBancoController');

    Route::get('/nmn_cat_empleados', 'nomina\nmn_cat_empleadosController@listar');
//  Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@nmn_cat_empleados');
    Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@get_empleados_edit');
    Route::resource('/nmn_cat_empleadosC', 'nomina\nmn_cat_empleadosController');

    # Rutas para el catálogo de conceptos de nómina ------------------------------
    Route::get('/nmn_cat_conceptos','nomina\nmn_cat_conceptosController@listar');
    Route::get('/nmn_cat_conceptos/conceptos','nomina\nmn_cat_conceptosController@getConceptos');
    Route::get('/nmn_cat_conceptos/edit/{id_concepto}','nomina\nmn_cat_conceptosController@get_conceptos_edit');
    Route::resource('/nmn_cat_conceptosC', 'nomina\nmn_cat_conceptosController');

    Route::get('/ctb_tipos_cambio', 'contabilidad\ctb_tipos_cambioController@listar');
    Route::resource('/ctb_tipos_cambioC', 'contabilidad\ctb_tipos_cambioController');

    Route::get('/ctb_cat_centros_costo', 'contabilidad\ctb_cat_centros_costoController@listar');
    Route::resource('/ctb_cat_centros_costoC', 'contabilidad\ctb_cat_centros_costoController');

    Route::get('/ctb_tipos_centros', 'contabilidad\ctb_tipos_centros_costoController@listar');
    Route::resource('/ctb_tipos_centrosC', 'contabilidad\ctb_tipos_centros_costoController');

    Route::get('/ctb_documentos_partidas', 'contabilidad\ctb_documentos_partidasController@listar');
    Route::resource('/ctb_documentos_partidasC', 'contabilidad\ctb_documentos_partidasController');

    Route::get('/ctb_reservacfdi', 'contabilidad\ctb_reservacfdi_impuestosController@listar');
    Route::resource('/ctb_reservacfdiC', 'contabilidad\ctb_reservacfdi_impuestosController');

    Route::get('/ctb_reserva_cfdi', 'contabilidad\ctb_reserva_cfdiController@listar');
    Route::resource('/ctb_reserva_cfdiC', 'contabilidad\ctb_reserva_cfdiController');

    Route::get('/cmp_cat_proveedores', 'compras\cmp_cat_proveedoresController@listar');
    Route::get('/cmp_cat_proveedores/edit/{id_proveedores}', 'compras\cmp_cat_proveedoresController@get_proveedor_edit');
    Route::resource('/cmp_cat_proveedoresC', 'compras\cmp_cat_proveedoresController');

    Route::get('/tabla_recurrente/entidad/', 'tabla_recurrente\tbl_recurrenteController@get_entidad');
    Route::get('/tabla_recurrente/municipio/{entidad}', 'tabla_recurrente\tbl_recurrenteController@get_municipio');
    Route::get('/tabla_recurrente/localidad/{municipio}/{entidad}', 'tabla_recurrente\tbl_recurrenteController@get_localidad');
    Route::get('/tabla_recurrente/codigo_postal/{municipio}/{entidad}', 'tabla_recurrente\tbl_recurrenteController@get_codigo_postal');
    Route::get('/tabla_recurrente/banco/', 'tabla_recurrente\tbl_recurrenteController@get_banco');
    Route::get('/tabla_recurrente/sat_banco/', 'tabla_recurrente\tbl_recurrenteController@get_sat_banco');
    Route::get('/tabla_recurrente/razon_social/', 'tabla_recurrente\tbl_recurrenteController@get_razon_social');
    Route::get('/tabla_recurrente/id_centrocosto/', 'tabla_recurrente\tbl_recurrenteController@get_id_centrocosto');

    Route::get('/nmn_cat_empleados/cp/{estado}/{municipio}/{asentamiento}/{tipo_asentamiento}', 'nomina\nmn_cat_empleadosController@get_cps');

    //falta acomodar
    Route::get('/glx_companias', 'administracion\glx_companiasController@listar');
    Route::resource('/glx_companiasC', 'administracion\glx_companiasController');

    Route::get('/syscat_usuariostransacciones/{cve_usuario}', 'administracion\syscat_usuariostransaccionesController@index');
    Route::resource('/syscat_usuariostransaccionesC', 'administracion\syscat_usuariostransaccionesController');
});
