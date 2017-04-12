@extends('main')
@section('title')
	Catálogo de bancos
@stop
@section('panel')
	<nav id = 'menu' class = 'panel-menu' role = 'navigation'>
		<div class = 'row'>
			<div class = 'col-xs-12'>
				
			</div>
		</div>
	</nav>
@stop
@section('report_title')
	CATALOGO DE BANCOS(SAT)
@stop
@section('report')
	<div class = 'panel-body' id = 'gridCrud'>
		<!-- Modal para editar la informacion de un row o dar de alta -->
		<div class = 'modal fade' id = 'modal-alter-row' tabindex = '-1' role = 'dialog' aria-labelledby = 'myModalLabel'>
			<div class = 'modal-dialog modal-sm' role = 'document'>
				<div class = 'modal-content'>
					<div class = 'modal-header'>
						<button type = 'button' class = 'close' data-dismiss = 'modal' aria-label = 'Close'><span aria-hidden = 'true'>×</span></button>
						<h4 class = 'modal-title' id = 'myModalLabel'><i class =' fa fa-edit'></i> Banco</h4>
					</div>
					<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'alterRow(row)'>
						<div class = 'modal-body'>
							<div class = 'form-group'>
								<label for = 'title'>Clave de Banco</label>
								<input type = 'text' name = 'cve_banco' class = 'form-control input-sm' v-model = 'row.cve_banco'/>
							</div>
							<div class = 'form-group'>
								<label for = 'title'>Nombre Corto</label>
								<input type = 'text' name = 'nom_corto_banco' class = 'form-control input-sm' v-model = 'row.nom_corto_banco'/>
							</div>
							<div class = 'form-group'>
								<label for = 'title'>Nombre</label>
								<textarea name = 'nom_banco' class = 'form-control input-sm' v-model = 'row.nom_banco'></textarea>
							</div>
						</div>
						<div class = 'modal-footer'>
							<div class = 'form-group text-right'>
								<button class = 'btn btn-sm btn-outline btn-success'><i class = 'fa fa-floppy-o'></i> Guardar</button>
								<button type = 'button' class = 'btn btn-sm btn-outline btn-default' data-dismiss = 'modal'><i class = 'fa fa-thumbs-down'></i> Cancelar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Modal para confirmar el borrar de un row -->
		<div class = 'modal fade' id = 'modal-delete-row' tabindex = '-1' role = 'dialog' aria-labelledby = 'myModalLabel'>
			<div class = 'modal-dialog modal-sm' role = 'document'>
				<div class = 'modal-content'>
					<div class = 'modal-header'>
						<button type = 'button' class = 'close' data-dismiss = 'modal' aria-label = 'Close'><span aria-hidden = 'true'>×</span></button>
						<h4 class = 'modal-title' id = 'myModalLabel'><i class =' fa fa-times-circle'></i> Banco</h4>
					</div>
					<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'deleteRow(row)'>
						<div class = 'modal-body'>
							<strong>¿Estás seguro de dar de borrar el registro seleccionado?</strong>
						</div>
						<div class = 'modal-footer'>
							<div class = 'form-group text-right'>
								<button type = 'submit' class = 'btn btn-sm btn-outline btn-primary'><i class = 'fa fa-floppy-o'></i> Si</button>
								<button type = 'button' class = 'btn btn-sm btn-outline btn-default' data-dismiss = 'modal'><i class = 'fa fa-thumbs-down'></i> No</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-xs-12 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8'>
				<div class = 'row'>
					<div class = 'col-xs-6 col-sm-3 col-md-3 col-lg-3'>
						<form id = 'search'>
							<div class = 'form-group'>
								<input type = 'text' class = 'form-control input-sm' name = 'query' v-model = 'searchQuery' placeholder = 'Buscar...'>
							</div>
						</form>
					</div>
					<div class = 'col-xs-6 col-sm-9 col-md-9 col-lg-9 text-right'>
						<div class = 'btn-group btn-group-sm'>
							<button type = 'button' class = 'btn btn-outline btn-success' @click = "openModal('create')"><i class = 'fa fa-plus-square'></i> <font class = 'hidden-xs'>Alta</font></button>
							<button type = 'button' class = 'btn btn-outline btn-warning' @click = "openModal('update')"><i class = 'fa fa-edit'></i> <font class = 'hidden-xs'>Editar</font></button>
							<button type = 'button' class = 'btn btn-outline btn-danger' @click = "openModal('delete')"><i class = 'fa fa-times'></i> <font class = 'hidden-xs'>Baja</font></button>
						</div>
					</div>
				</div>
				<div class = 'row'>
					<div class = 'col-xs-12'>
						<div class = 'table-responsive'>
							<data-grid :data = 'gridData' :columns = 'gridColumns' :filter-key = 'searchQuery'>
							</data-grid>
						</div>
					</div>
				</div>
				<div class = 'row'>
					<div class = 'col-xs-5 col-sm-3 col-md-3 col-lg-3'>
					<div class = 'input-group'>
						<select class = 'form-control' name = 'xPag' v-model = 'xPag'>
							<option>5</option>
							<option>10</option>
							<option>20</option>
							<option>100</option>
							<option>500</option>
							<option>Todos</option>
						</select>
						<span class= 'input-group-btn'>
							<button class = 'btn btn-default' @click.prevent="changePage(1)"><i class = 'fa fa-refresh'></i></button>
						</span>
						</div>
					</div>
					<div class = 'col-xs-7 col-sm-9 col-md-9 col-lg-9 text-right'>
						<nav aria-label = 'Page navigation'>
							<ul class = 'pagination'>
								<li v-if = 'pagination.current_page > 1'><a href = '#' aria-label = 'Anterior' @click.prevent="changePage(pagination.current_page - 1)"><span aria-hidden = 'true'>«</span></a></li>
								<li v-for = 'page in pagesNumber' v-bind:class = "[ page == isActived ? 'active' : '']"><a href = '#' @click.prevent="changePage(page)">@{{page}}</a></li>
								<li v-if = 'pagination.current_page < pagination.last_page'><a href = '#' aria-label = 'Siguiente' @click.prevent="changePage(pagination.current_page + 1)"><span aria-hidden = 'true'>»</span></a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('extra_js')
	<script type='text/x-template' id = 'grid-template'>
		<table class = 'table table-hover table-condensed table-bordered'>
			<thead>
				<tr>
					<th v-for = 'key in columns' @click = 'sortBy(key)' :class = '{active: sortKey == key}'>@{{key | capitalize}} <span class = 'arrow' :class = "sortOrders[key] > 0 ? 'asc' : 'dsc'"></span></th>
				</tr>
			</thead>
			<tbody>
				<tr v-bind:class="[entry.active_class]" v-for = 'entry in data | filterBy filterKey | orderBy sortKey sortOrders[sortKey]' @click = "fillRow(entry)">
					<td v-for = 'key in columns'>@{{entry[key]}}</td>
				</tr>
			</tbody>
		</table>
	</script>
	<script type = 'text/javascript'>
		Vue.http.headers.common['X-CSRF-TOKEN'] = $('#token').attr('value');
		Vue.component('data-grid', {
			template: '#grid-template',
			props: {
				data: Array,
				columns: Array,
				filterKey: String
			},
			data: function () {
				var sortOrders = {}
				this.columns.forEach(function (key) {
					sortOrders[key] = 1
				})
				return {
					sortKey: '',
					sortOrders: sortOrders
				}
			},
			methods: {
				sortBy: function (key) {
					this.sortKey = key
					this.sortOrders[key] = this.sortOrders[key] * -1
				},
				fillRow: function(row){
					$.each(this.data, function(i, item){
						item.active_class = '';
						if(item.id_banco == row.id_banco){
							item.active_class = 'info';
						}
					});
					grid_model.row.id_banco = row.id_banco;
					grid_model.row.cve_banco = row.cve_banco;
					grid_model.row.nom_corto_banco = row.nom_corto_banco;
					grid_model.row.nom_banco = row.nom_banco;
					grid_model.row.accion = 'update';
				}
			}
		})
		var grid_model = new Vue({
			el: '#gridCrud',
			data: {
				searchQuery: '',
				gridColumns: ['cve_banco', 'nom_corto_banco', 'nom_banco'],
				gridData: [],
				pagination:{
					total: 0, 
					per_page: 2,
					from: 1, 
					to: 0,
					current_page: 1
				},
				xPag: 5,
				offset: 4,
				row:{'id_banco':'', 'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':'', 'active_class': ''},
			},
			computed:{
				isActived: function (){
					return this.pagination.current_page;
				},
				pagesNumber: function () {
					if (!this.pagination.to) {
						return [];
					}
					var from = this.pagination.current_page - this.offset;
					if (from < 1) {
						from = 1;
					}
					var to = from + (this.offset * 2);
					if (to >= this.pagination.last_page){
						to = this.pagination.last_page;
					}
					var pagesArray = [];
					while (from <= to) {
						pagesArray.push(from);
						from++;
					}
					return pagesArray;
				}
			},
			ready: function(){
				this.getData(this.pagination.current_page, this.xPag);
			},
			methods: {
				getData: function(page, xPag){
					this.$http.get('crud-bancos?page='+page+'&xPag='+xPag, {before(request){
						toastr.info("<i class = 'fa fa-refresh fa-spin'></i> Generando reporte, espera por favor", 'Mensaje del sistema', {timeOut: 0});
						if(this.previousRequest){
							this.previousRequest.abort();
						}
						this.previousRequest = request;
					}}).then((response)=>{
						this.$set('gridData', response.data.data.data);
						this.$set('pagination', response.data.pagination);
						toastr.clear();
					});
				},
				openModal: function(option){
					if(option == 'create'){
						this.row.id_banco = '';
						this.row.cve_banco = '';
						this.row.nom_corto_banco = '';
						this.row.nom_banco = '';
						this.row.accion = 'create';
						$('#modal-alter-row').modal('show');
					} else if(option == 'update'){
						if(this.row.id_banco == ''){
							toastr.clear();
							toastr.info("Selecciona un registro del reporte para editar", 'Mensaje del sistema', {timeOut: 5000});
						} else{
							$('#modal-alter-row').modal('show');
						}
					} else if(option == 'delete'){
						if(this.row.id_banco == ''){
							toastr.clear();
							toastr.info("Selecciona un registro del reporte para editar", 'Mensaje del sistema', {timeOut: 5000});
						} else{
							$('#modal-delete-row').modal('show');
						}
					}
				},
				alterRow: function(row){
					row.accion=='create'?this.createRow(row):this.updateRow(row);
				},
				createRow: function(row){
					this.$http.post('crud-bancos',row, {before(request){
						toastr.info("<i class = 'fa fa-refresh fa-spin'></i> Guardando registro, espera por favor", 'Mensaje del sistema', {timeOut: 0});
						if(this.previousRequest){
							this.previousRequest.abort();
						}
						this.previousRequest = request;
					}}).then((response)=>{
						this.row = {'id_banco':'', 'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':'', 'active_class': ''};
						$('#modal-alter-row').modal('hide');
						toastr.clear();
						toastr.success('Nuevo registro agregado', 'Mensaje del sistema', {timeOut: 5000});
						this.changePage(this.pagination.current_page);
					}, (response)=>{
						toastr.clear();
						var errors = '<br>';
						$.each(response.data, function(i, row){
							errors += row + '<br>';
						});
						toastr.warning('Resolver los siguientes problemas: ' + errors, 'Mensaje del sistema', {timeOut: 10000});
					});
				},
				updateRow: function(row){
					this.$http.put('crud-bancos/'+row.id_banco,row, {before(request){
						toastr.info("<i class = 'fa fa-refresh fa-spin'></i> Actualizando registro, espera por favor", 'Mensaje del sistema', {timeOut: 0});
						if(this.previousRequest){
							this.previousRequest.abort();
						}
						this.previousRequest = request;
					}}).then((response)=>{
						this.row = {'id_banco':'', 'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':'', 'active_class': ''};
						$('#modal-alter-row').modal('hide');
						toastr.clear();
						toastr.success('Registro actualizado con éxito', '¡Éxito!', {timeOut: 5000});
						this.changePage(this.pagination.current_page);
					}, (response)=>{
						toastr.clear();
						var errors = '<br>';
						$.each(response.data, function(i, row){
							errors += row + '<br>';
						});
						toastr.warning('Resolver los siguientes problemas: ' + errors, 'Mensaje del sistema', {timeOut: 10000});
					});
				},
				deleteRow: function(row){
					this.$http.delete('crud-bancos/'+row.id_banco, {before(request){
						toastr.info("<i class = 'fa fa-refresh fa-spin'></i> Borrando registro, espera por favor", 'Mensaje del sistema', {timeOut: 0});
						if(this.previousRequest){
							this.previousRequest.abort();
						}
						this.previousRequest = request;
					}}).then((response)=>{
						this.changePage(this.pagination.current_page);
						toastr.clear();
						$('#modal-delete-row').modal('hide');
						toastr.success('Registro borrado con éxito.', 'Mensaje del sistema', {timeOut: 5000});
					});
				},
				changePage: function (page){
					this.getData(page, this.xPag);
					this.pagination.current_page = page;
				}
			}
		})
	</script>
@stop