<?php
Route::get('/', function () {
	return view('main');
});
# contabilidad #############################
	Route::group(['middleware'=>['web']], function(){
		Route::get('catalogo-de-cuentas-contables', 'contabilidad\ctb_cat_cuentasController@ArbolDeCuentas');
		Route::resource('catalogo-de-cuentas-contables/crud', 'contabilidad\ctb_cat_cuentasController');
	});
# Tesoreria ################################
	# Catalogo de bancos
	Route::group(['middleware' => ['web']], function() {
		Route::get('catalogo-de-bancos', 'tesoreria\ctb_cat_bancosController@Bancos');
		Route::resource('crud-bancos', 'tesoreria\ctb_cat_bancosController');
	});

	Route::get('/contabilidad/ctb_cat_monedas', 'contabilidad\ctb_cat_monedasController@listar');
	Route::resource('/contabilidad/ctb_cat_monedasController', 'contabilidad\ctb_cat_monedasController');


	Route::get('/contabilidad/ctb_cat_concepto_financiero', 'contabilidad\ctb_cat_concepto_financieroController@listar');
	Route::resource('/contabilidad/ctb_cat_concepto_financieroController', 'contabilidad\ctb_cat_concepto_financieroController');

# nomina ###################################
# compras ##################################
# Ventas ###################################
# Inventarios ##############################
# Produccion ###############################
# Configuracion ############################