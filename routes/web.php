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
# Nomina ###################################
# Compras ##################################
# Ventas ###################################
# Inventarios ##############################
# Produccion ###############################
# Configuracion ############################