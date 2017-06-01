<?php

Route::get('/', function() {
    return redirect('autentificacion/login');
});

use App\Models\contabilidad\ctb_cat_concepto_financiero;

Route::get('/conceptos', function() {
    return ctb_cat_concepto_financiero::where('catalogo_sat', 'like', '105.%')->count();
});




Route::group(['middleware' => ['web']], function() {
    Route::get('solicitud_pagos', 'compras\cmp_solicitud_pagoController@listar');
});


Route::get('autentificacion/login', 'autentificacion\loginController@index');
Route::post('autentificacion/logincontroller', 'autentificacion\loginController@login');
Route::get('autentificacion/logincontroller/logout', 'autentificacion\loginController@logout');



Route::group(['middleware' => 'autentificacion'], function () {


    Route::get('/inicio', function () {
        return view('welcome');
    });

    //    Autentificacion

    Route::get('/autentificacion/usuarios', 'autentificacion\usuariosController@listar');
    Route::resource('autentificacion/usuariosC', 'autentificacion\usuariosController');

// ---------    Tesoreria 

    Route::get('/catalogo-de-bancos', 'tesoreria\ctb_cat_bancosController@Bancos');
    Route::resource('crud-bancos', 'tesoreria\ctb_cat_bancosController');


// ----------   Contabilidad
    Route::get('/catalogo-de-cuentas-contables', 'contabilidad\ctb_cat_cuentasController@ArbolDeCuentas');
    Route::resource('catalogo-de-cuentas-contables/crud', 'contabilidad\ctb_cat_cuentasController');

    Route::get('/ctb_cat_monedas', 'contabilidad\ctb_cat_monedasController@listar');
    Route::resource('/ctb_cat_monedasC', 'contabilidad\ctb_cat_monedasController');

    Route::get('/ctb_cat_concepto_financiero', 'contabilidad\ctb_cat_concepto_financieroController@listar');
    Route::resource('ctb_cat_concepto_financieroC', 'contabilidad\ctb_cat_concepto_financieroController');

// ---------- Misceláneo

    Route::get('/autentificacion/usuarios', 'autentificacion\usuariosController@listar');
    Route::resource('autentificacion/usuariosC', 'autentificacion\usuariosController');


// ----------  Nómina    

    Route::get('/nmn_sat_catbanco', 'nomina\nmn_sat_catBancoController@listar');
    Route::resource('/nmn_sat_catbancoC', 'nomina\nmn_sat_catBancoController');

    Route::get('/nmn_cat_empleados', 'nomina\nmn_cat_empleadosController@listar');
//  Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@nmn_cat_empleados');
    Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@get_empleados_edit');
    Route::resource('/nmn_cat_empleadosC', 'nomina\nmn_cat_empleadosController');

    # Rutas para el catálogo de conceptos de nómina ------------------------------
    Route::get('/nmn_cat_conceptos', 'nomina\nmn_cat_conceptosController@listar');
    Route::get('/nmn_cat_conceptos/conceptos', 'nomina\nmn_cat_conceptosController@getConceptos');
    Route::get('/nmn_cat_conceptos/edit/{id_concepto}', 'nomina\nmn_cat_conceptosController@get_conceptos_edit');
    Route::resource('/nmn_cat_conceptosC', 'nomina\nmn_cat_conceptosController');

    # Rutas para los tipos de contrato en Nómina

    Route::get('/nmn_cat_tipo_contrato','nomina\nmn_cat_tipo_contratoController@listar');
    #Route::get('/nmn_cat_tipo_contrato','nomina\nmn_cat_tipo_contratoController@getTipoContrato');
    Route::get('/nmn_cat_tipo_contrato','nomina\nmn_cat_tipo_contratoController@getTipoJornada');


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



// ----------   Inventario
    Route::get('/inv_cat_productos/gtin', 'inventario\inv_cat_productosController@get_gtin');
    //cat_productos obtener la lista continua despues de hacer la seleccion de segmento familia clase o bloque
    Route::get('/inv_cat_productos/segmento', 'inventario\inv_cat_productosController@get_segmento');
    Route::get('/inv_cat_productos/familia/{segmento}', 'inventario\inv_cat_productosController@get_familia');
    Route::get('/inv_cat_productos/clase/{segmento}/{familia}', 'inventario\inv_cat_productosController@get_clase');
    Route::get('/inv_cat_productos/bloque/{segmento}/{familia}/{bloque}', 'inventario\inv_cat_productosController@get_bloque');
    //cat_productos obtener la lista continua despues de hacer la seleccion de segmento familia clase o bloque
    Route::get('/inv_cat_productos/segmento/{cve_segmento}', 'inventario\inv_cat_productosController@get_nombre_segmento');
    Route::get('/inv_cat_productos/familia/{segmento}/{cve_familia}', 'inventario\inv_cat_productosController@get_nombre_familia');
    Route::get('/inv_cat_productos/clase/{segmento}/{familia}/{cve_clase}', 'inventario\inv_cat_productosController@get_nombre_clase');
    Route::get('/inv_cat_productos/bloque/{segmento}/{familia}/{bloque}/{cve_bloque}', 'inventario\inv_cat_productosController@get_nombre_bloque');
    Route::get('/inv_cat_productos/unidad_medida/{cve_unidad_medida}', 'inventario\inv_cat_productosController@get_unidad_medida');

    Route::get('/inv_cat_productos', 'inventario\inv_cat_productosController@listar');
    Route::get('/inv_cat_productos/edit/{cve_cat_producto}', 'inventario\inv_cat_productosController@get_productos_edit');
    Route::resource('/inv_cat_productosC', 'inventario\inv_cat_productosController');
// ----------   Compras

    Route::get('/cmp_cat_proveedores', 'compras\cmp_cat_proveedoresController@listar');
    Route::get('/cmp_cat_proveedores/edit/{id_proveedores}', 'compras\cmp_cat_proveedoresController@get_proveedor_edit');
    Route::resource('/cmp_cat_proveedoresC', 'compras\cmp_cat_proveedoresController');

    Route::get('/cmp_solicitud_pago/beneficiario/', 'compras\cmp_solicitud_pagoController@get_beneficiarios');
    Route::get('/cmp_solicitud_pago/conceptos/', 'compras\cmp_solicitud_pagoController@get_conceptos');
    Route::post('/cmp_solicitud_pagoC2','compras\cmp_solicitud_pagoController@storePartidas');
    Route::resource('/cmp_solicitud_pagoC','compras\cmp_solicitud_pagoController');

// ----------   Nomina
    Route::get('/nmn_cat_conceptos', 'nomina\nmn_cat_conceptosController@listar');
    Route::get('/nmn_cat_conceptos/conceptos', 'nomina\nmn_cat_conceptosController@getConceptos');
    Route::get('/nmn_cat_conceptos/edit/{id_concepto}', 'nomina\nmn_cat_conceptosController@get_conceptos_edit');
    Route::resource('/nmn_cat_conceptosC', 'nomina\nmn_cat_conceptosController');

    Route::get('/nmn_sat_catbanco', 'nomina\nmn_sat_catBancoController@listar');
    Route::resource('/nmn_sat_catbancoC', 'nomina\nmn_sat_catBancoController');

    Route::get('/nmn_cat_empleados', 'nomina\nmn_cat_empleadosController@listar');
//    Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@nmn_cat_empleados');
    Route::get('/nmn_cat_empleados/edit/{id_empleado}', 'nomina\nmn_cat_empleadosController@get_empleados_edit');
    Route::resource('/nmn_cat_empleadosC', 'nomina\nmn_cat_empleadosController');


    Route::get('/nmn_cat_departamentos/departamentos', 'nomina\nmn_cat_departamentosController@get_departamentos');
    Route::get('/nmn_cat_departamentos', 'nomina\nmn_cat_departamentosController@listar');
    Route::resource('/nmn_cat_departamentosC', 'nomina\nmn_cat_departamentosController');
    Route::post('/nmn_cat_departamentos/editar_departamento/{id_centrocosto}', 'nomina\nmn_cat_departamentosController@update');


// ---------   Compras
    Route::get('/cmp_solicitud_pagoController/beneficiario', 'compras\cmp_solicitud_pagoController@get_beneficiarios');
    Route::get('/cmp_solicitud_pagoController/conceptos', 'compras\cmp_solicitud_pagoController@get_conceptos');



// ----------   Tabla recurrente   -----------------
    Route::get('/tabla_recurrente/unidad_medida/', 'tabla_recurrente\tbl_recurrenteController@get_unidad_medida');
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
