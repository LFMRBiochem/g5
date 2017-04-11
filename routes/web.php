<?php
Route::get('/', function () {
	return view('main');
});
# Contabilidad #############################
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
# Nomina ###################################
# Compras ##################################
# Ventas ###################################
# Inventarios ##############################
# Produccion ###############################
# Configuracion ############################