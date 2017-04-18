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
			border:1px solid #ddd;
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
			border-left:1px solid #ddd;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #ddd;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border:1px solid #ddd;
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
			color:#ddd
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

	<div class = 'modal fade' id = 'modal-cuenta' tabindex = '-1' role = 'dialog' aria-labelledby = 'myModalLabel'>
		<div class = 'modal-dialog modal-sm' role = 'document'>
			<div class = 'modal-content'>
				<div class = 'modal-header'>
					<button type = 'button' class = 'close' data-dismiss = 'modal' aria-label = 'Close'><span aria-hidden = 'true'>×</span></button>
					<h4 class = 'modal-title' id = 'myModalLabel'><i class =' fa fa-edit'></i> Cuenta Contable</h4>
				</div>
				<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'updateCuenta(row)'>
					<div class = 'modal-body'>
						<input type = 'hidden' name = 'id_cuenta' v-model = 'id_cuenta'>
						<div class = 'form-group'>
							<label>Cuenta contable</label>
							<input type = 'text' class = 'form-control input-sm' name = 'cuenta_contable' v-model = 'row.cuenta_contable'>
						</div>
						<div class = 'form-group'>
							<label>Descripcion</label>
							<input type = 'text' class = 'form-control input-sm' name = 'descripcion' v-model = 'row.descripcion'>
						</div>
						<div class = 'form-group'>
							<label>Naturaleza</label>
							<input type = 'text' class = 'form-control input-sm' name = 'naturaleza' v-model = 'row.naturaleza'>
						</div>
						<div class = 'form-group'>
							<label>Clave moneda</label>
							<input type = 'text' class = 'form-control input-sm' name = 'cve_moneda' v-model = 'row.cve_moneda'>
						</div>
						<div class = 'form-group'>
							<label>Estatus</label>
							<input type = 'text' class = 'form-control input-sm' name = 'estatus' v-model = 'row.estatus'>
						</div>
					</div>
					<div class = 'modal-footer'>
						<div class = 'pull-right'>
							<button class = 'btn btn-sm btn-outline btn-primary'><i class = 'fa fa-thumbs-up'></i> Guardar</button>
							<button type = 'button' class = 'btn btn-sm btn-outline btn-default' data-dismiss = 'modal'><i class = 'fa fa-thumbs-down'></i> Cancelar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

		<nav id = 'menu' class = 'panel-menu' role = 'navigation'>
			<div class = 'row'>
				<div class = 'col-xs-12'>
					<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'getCuentas()'>
						<div class = 'form-group'>
							<label><i class = 'fa fa-filter'></i> Nivel</label>
							<select class = 'form-control input-sm' name = 'nivel' v-model = 'nivel'>
								<option value = '0'>Cuentas de mayor</option>
								<option value = '1'>Cuentas contables</option>
								<option value = '2'>Conceptos financieros</option>
								<option value = '3'>Centros de costo</option>
							</select>
						</div>
						<div class = 'form-group pull-right'>
							<button class = 'btn btn-sm btn-outline btn-primary'><i class = 'fa fa-thumbs-up'></i> Generar</button>
						</div>
					</form>
				</div>
			</div>
		</nav>
		<div class = 'panel-body'>
			<div class = 'row'>
				<div class = 'col-xs-12 col-sm-6 col-md-6 col-lg-5'>
					<ul class = 'tree'>
						<item class = 'item' :model = 'treeData'></item>
					</ul>
				</div>
				<div class = 'col-xs-12 col-sm-6 col-md-6 col-lg-7' v-if = 'visiblePanel'>
					<div class = 'table-responsive'>
						<table class = 'table table-hover table-bordered table-condensed'>
							<thead>
								<tr>
									<th class = 'text-center'>Fecha</th>
									<th>Concepto</th>
									<th class = 'text-right'>Saldo inicial</th>
									<th class = 'text-right'>Cargos</th>
									<th class = 'text-right'>Abonos</th>
									<th class = 'text-right'>Saldo final</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
								<tr>
									<td class = 'text-center'>04-marzo-2017</td>
									<td>Cargo/abono por ...</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
									<td class = 'text-right'>0.00</td>
								</tr>
							</tbody>
						</table>
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
				<span @click = 'openModal(model)' title = 'Mostrar información de la cuenta contable'><i v-if = '!isFolder' class = 'fa fa-leaf'></i> @{{model.cuenta_contable}} @{{model.descripcion}}</span>
				<span @click = 'openPanel(model)' title = 'Mostrar auxiliar contable'><i class = 'fa fa-dollar'></i></span>
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
				model: Object,
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
				openModal: function(row){
					tree.row.id_cuenta = row.id_cuenta;
					tree.row.cuenta_contable = row.cuenta_contable;
					tree.row.naturaleza = row.naturaleza;
					tree.row.descripcion = row.descripcion;
					tree.row.cve_moneda = row.cve_moneda;
					tree.row.estatus = row.estatus;
					$('#modal-cuenta').modal('show');
				},
				openPanel: function(row){
					tree.visiblePanel = true;
				}
			}
		})
		var tree = new Vue({
			el: '#arbol',
			data: {
				treeData: {descripcion: 'Catálogo de Cuentas'},
				nivel: 0,
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
						toastr.info("Catálogo cargado con éxito", 'Mensaje del sistema', {timeOut: 0});
						this.$set('treeData', response.data);
						toastr.clear();
					});
				}
			}
		})
	</script>
@stop