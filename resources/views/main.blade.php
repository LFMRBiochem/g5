<!--
	Plantilla principal del sistema
	Version 1.0.0
	Autor: Diego Guerrero
	Fecha: 2017-04-17
-->
<!DOCTYPE html>
<html lang = 'en'>
	<head>
		<meta charset = 'utf-8'>
		<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
		<meta name = 'viewport' content = 'width = device-width, initial-scale = 1'>
		<!-- Token de seguridad laravel -->
		<meta id = 'token' name = 'token' value = '{{csrf_token()}}'>
		<!-- Yield para incrustar el titulo de la vista -->
		<title>@yield('page_title')</title>
		<!-- Estilos esenciales para el funcionamiento de las vistas del sistema -->
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('bootstrap/css/bootstrap.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('font-awesome/css/font-awesome.min.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href="{{asset('smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('toastr/toastr.min.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('master.css')}}">
		<!-- Yield para incrustar codigo css opcional para cada vista -->
		@yield('extra_css')
	</head>
	<body>
	<!-- Includa para cargar el navbar del sistema -->
		@include('parcials/navbar')
		<!-- Yield para mostrar el panel flotante de parametros -->
		@yield('panel')
		<div class = 'container-fluid'>
			<div class = 'row'>
				<div class = 'col-xs-12'>
					<div class = 'panel panel-default'>
						<div class = 'panel-heading'>
						<!-- Yield para mostrar o no el boton para desplegar el panel de parametros -->
							@yield('btn_open_panel')
							<!-- Yield para incrustar el titulo del reporte en el panel principal -->
							<strong>@yield('report_title')</strong>
						</div>
						<!-- Yield para incrustar el reporte que contendra la vista -->
						@yield('report')
					</div>
				</div>
			</div>
		</div>
		<!-- Plugins esenciales para el funcionamiento basico de las vistas -->
		<script type = 'text/javascript' src = "{{asset('jquery.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('smartmenus/jquery.smartmenus.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('bigSlide.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('toastr/toastr.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('vue-1.0.28/vue.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('vue-1.0.28/vue-resource.js')}}"></script>
		<script>
			$(document).ready(function(){
				// Configuracion inicial del panel de parametros del reporte
				var bigSlideAPI = ($('#btn_show_panel').bigSlide({
					easyClose: true,
					state: 'closed'
				})).bigSlideAPI;
			});
		</script>
		<!-- Yield para incrustar codigo javascript adicional a la vista -->
		@yield('extra_js')
	</body>
</html>