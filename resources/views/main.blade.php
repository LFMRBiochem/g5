<!DOCTYPE html>
<html lang = 'en'>
	<head>
		<meta charset = 'utf-8'>
		<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
		<meta name = 'viewport' content = 'width = device-width, initial-scale = 1'>
		<meta id = 'token' name = 'token' value = '{{csrf_token()}}'>
		<title>@yield('page_title')</title>
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('bootstrap/css/bootstrap.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('font-awesome/css/font-awesome.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css')}}">
		<link rel = 'stylesheet' type = 'text/css' href = "{{asset('toastr/toastr.min.css')}}">
		<link rel = "stylesheet" type = 'text/css' href = "{{asset('master.css')}}">
		@yield('extra_css')
	</head>
	<body>
		@include('parcials/navbar')
		@yield('panel')
		<div class = 'container-fluid'>
			<div class = 'row'>
				<div class = 'col-xs-12'>
					<div class = 'panel panel-default'>
						<div class = 'panel-heading'>
							<button type = 'button' class = 'btn btn-xs btn-outline btn-default' title = 'Mostrar panel de controles' id = 'btn_show_panel'><i class = 'fa fa-list'></i></button>
							<strong>@yield('report_title')</strong>
						</div>
						@yield('report')
					</div>
				</div>
			</div>
		</div>
		<script type = 'text/javascript' src = "{{asset('jquery.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('smartmenus/jquery.smartmenus.min.js')}}"></script>
		<script type = "text/javascript" src = "{{asset('smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('bigSlide.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('toastr/toastr.min.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('vue-1.0.28/vue.js')}}"></script>
		<script type = 'text/javascript' src = "{{asset('vue-1.0.28/vue-resource.js')}}"></script>
		<script>
			$(document).ready(function() {
				$('#btn_show_panel').bigSlide({
					easyClose: true,
				});
			});
		</script>
		@yield('extra_js')
	</body>
</html>