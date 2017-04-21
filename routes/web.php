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
    Route::resource('/nmn_cat_empleadosC', 'nomina\nmn_cat_empleadosController');

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
    Route::resource('/cmp_cat_proveedoresC', 'compras\cmp_cat_proveedoresController');

    Route::get('/cmp_cat_proveedores/entidad/', 'compras\cmp_cat_proveedoresController@get_entidad');
    
//    Route::get('/cmp_cat_proveedoresC/entidad/{Cve_entidad}', 'compras\cmp_cat_proveedoresController@get_entidad');
//    Route::get('/cmp_cat_proveedoresC/municipio/{Cve_municipio}/{Cve_entidad}', 'compras\cmp_cat_proveedoresController@get_municipio');
//    Route::get('/cmp_cat_proveedoresC/municipio_entidad/{Cve_municipio}/{Cve_estado}', 'compras\cmp_cat_proveedoresController@get_municipio_entidad');
//    Route::get('/cmp_cat_proveedoresC/localidad/{Cve_localidad}', 'compras\cmp_cat_proveedoresController@get_localidad');

    //falta acomodar
    Route::get('/glx_companias', 'administracion\glx_companiasController@listar');
    Route::resource('/glx_companiasC', 'administracion\glx_companiasController');

    Route::get('/syscat_usuariostransacciones/{cve_usuario}', 'administracion\syscat_usuariostransaccionesController@index');
    Route::resource('/syscat_usuariostransaccionesC', 'administracion\syscat_usuariostransaccionesController');
});
