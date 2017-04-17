@extends('main')
@section('page_title')
	Árbol de Cuentas
@stop
@section('extra_css')
	<style type = 'text/css'>
		.tree {
			min-height:20px;
			padding:19px;
			margin-bottom:20px;
			border:1px solid #dddddd;
		}
		.tree div {
			min-width: 10px;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #dddddd;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #dddddd;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border:1px solid #dddddd;
			border-radius:5px;
			display:inline-block;
			padding:3px 8px;
			text-decoration:none
		}
		.tree li.parent_li>span {
			cursor:pointer
		}
		.tree>ul>li::before, .tree>ul>li::after {
			border:0
		}
		.tree li:last-child::before {
			height:30px
		}
		.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
			background:#eee;
			border:1px solid #94a0b4;
			color:#000
		}
		.bold {
			font-weight: bold;
		}
		.item {
			cursor: pointer;
		}
	</style>
@stop
@section('btn_open_panel')
	<button type = 'button' class = 'btn btn-xs btn-outline btn-default' title = 'Mostrar panel de controles' id = 'btn_show_panel'><i class = 'fa fa-list'></i></button>
@stop
@section('report_title')
	CATALOGO DE CUENTAS CONTABLES
@stop



@section('report')
	<div id = 'arbol'>
		<nav id = 'menu' class = 'panel-menu' role = 'navigation'>
			<div class = 'row'>
				<div class = 'col-xs-12'>
					<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'getCuentas()'>
						<div class = 'form-group'>
							<label><i class = 'fa fa-filter'></i> Nivel</label>
							<select class = 'form-control input-sm' name = 'nivel' v-model = 'nivel'>
								<option value = '0'>Cuentas de mayor</option>
								<option value = '1'>Nivel 1</option>
								<option value = '2'>Nivel 2</option>
								<option value = '3'>Nivel 3</option>
								<option value = '4'>Conceptos financieros</option>
								<option value = '5'>Centros de costo</option>
							</select>
						</div>
						<div class = 'checkbox'>
							<label><input type = 'checkbox'> Expandir catálogo </label>
						</div>
						<div class = 'form-group'>
							<button class = 'btn btn-sm btn-outline btn-primary'><i class = 'fa fa-thumbs-up'></i> Generar</button>
						</div>
					</form>
				</div>
			</div>
		</nav>
		<div class = 'panel-body'>
			<div class = 'row'>
				<div class = 'col-xs-6 col-sm-8 col-md-7 col-lg-7'>
					<ul class = 'tree'>
						<item class = 'item' :model = 'treeData'></item>
					</ul>
				</div>
				<div class = 'col-xs-6 col-sm-4 col-md-5 col-lg-5' v-if = 'visiblePanel'>
					<div class = 'panel panel-default'>
						<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'updateCuenta(row)'>
							<input type = 'hidden' name = 'id_cuenta' v-model = 'id_cuenta'>
							<div class = 'panel-body'>
								<div class = 'form-group'>
									<label>Cuenta contable</label>
									<input type = 'text' name = 'cuenta_contable' v-model = 'row.cuenta_contable'>
								</div>
								<div class = 'form-group'>
									<label>Descripcion</label>
									<input type = 'text' name = 'descripcion' v-model = 'row.descripcion'>
								</div>
								<div class = 'form-group'>
									<label>Naturaleza</label>
									<input type = 'text' name = 'naturaleza' v-model = 'row.naturaleza'>
								</div>
								<div class = 'form-group'>
									<label>Clave moneda</label>
									<input type = 'text' name = 'cve_moneda' v-model = 'row.cve_moneda'>
								</div>
								<div class = 'form-group'>
									<label>Estatus</label>
									<input type = 'text' name = 'estatus' v-model = 'row.estatus'>
								</div>
							</div>
							<div class = 'panel-footer pull-right'>
								<button class = 'btn btn-sm btn-outline btn-primary'><i class = ''></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Template para el componente del arbol -->
	<script type='text/x-template' id = 'item-template'>
		<li>
			<div :class = '{bold: isFolder}'>
				<span v-if = 'isFolder' @click = 'toggle' title = 'Mostrar/Ocultar ramas'><i v-bind:class = "open?'fa fa-folder-open-o':'fa fa-folder-o'"></i></span>
				<span @click = 'openPanel(model)' title = 'Mostrar información de la cuenta contable'><i v-if = '!isFolder' class = 'fa fa-leaf'></i> @{{model.cuenta_contable}} @{{model.descripcion}}</span>
			</div>
			<ul v-show = 'open' v-if = 'isFolder'>
				<item class = 'item' v-for = 'model in model.children' :model = 'model'></item>
			</ul>
		</li>
	</script>
@stop
@section('extra_js')
	<script type = 'text/javascript'>
		Vue.http.headers.common['X-CSRF-TOKEN'] = $('#token').attr('value');
		Vue.component('item', {
			template: '#item-template',
			props: {
				model: Object
			},
			data: function(){
				return {
					open: false
				}
			},
			computed: {
				isFolder: function () {
					return this.model.children && this.model.children.length
				}
			},
			methods: {
				toggle: function(){
					if(this.isFolder){
						this.open = !this.open
					}
				},
				openPanel: function(row){
					tree.row.id_cuenta = row.id_cuenta;
					tree.row.cuenta_contable = row.cuenta_contable;
					tree.row.naturaleza = row.naturaleza;
					tree.row.descripcion = row.descripcion;
					tree.row.cve_moneda = row.cve_moneda;
					tree.row.estatus = row.estatus;
					tree.visiblePanel = true;
				}
			}
		})
		var tree = new Vue({
			el: '#arbol',
			data: {
				treeData: {descripcion: 'Catálogo de Cuentas'},
				nivel: 0,
				expandeArbol: false,
				visiblePanel: false,
				row: {'id_cuenta': '', 'cuenta_contable': '', 'naturaleza': '', 'descripcion': '', 'cve_moneda': '', 'estatus': ''}
			},
			ready: function(){
				this.getCuentas();
			},
			methods: {
				getCuentas: function(){
					this.$http.get('catalogo-de-cuentas-contables/crud?nivel='+this.nivel, {before(request){
						toastr.info("Espera mientras se carga el catálogo de cuentas <i class = 'fa fa-refresh fa-spin'></i>", 'Mensaje del sistema', {timeOut: 0});
						if(this.previousRequest){
							this.previousRequest.abort();
						}
						this.previousRequest = request;
					}}).then((response)=>{
						this.$set('treeData', response.data);
						toastr.clear();
					});
				}
			}
		})
	</script>
@stop