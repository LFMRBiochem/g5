@extends('main')
@section('title')
	Catálogo de Bancos
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
	<div class = 'panel-body' id = 'manage-bancos'>
		<!-- Modal para dar de alta un nuevo banco -->
		<div class = 'modal fade' id = 'create-banco' tabindex = '-1' role = 'dialog' aria-labelledby = 'myModalLabel'>
			<div class = 'modal-dialog' role = 'document'>
				<div class = 'modal-content'>
					<div class = 'modal-header'>
						<button type = 'button' class = 'close' data-dismiss = 'modal' aria-label = 'Close'><span aria-hidden = 'true'>×</span></button>
						<h4 class = 'modal-title' id = 'myModalLabel'><i class = 'fa fa-plus'></i> Alta Banco</h4>
					</div>
					<div class = 'modal-body'>
						<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'createBanco'>
							<div class = 'form-group'>
								<label for = 'cve_banco'>Clave de Banco</label>
								<input type = 'text' name = 'cve_banco' class = 'form-control input-sm' v-model = 'newBanco.cve_banco'/>
								<span v-if = "formErrors['cve_banco']" class = 'error text-danger'>@{{ formErrors['cve_banco'] }}</span>
							</div>
							<div class = 'form-group'>
								<label for = 'nom_corto_banco'>Nombre corto</label>
								<input type = 'text' name = 'nom_corto_banco' class = 'form-control input-sm' v-model = 'newBanco.nom_corto_banco'/>
								<span v-if = "formErrors['nom_corto_banco']" class = 'error text-danger'>@{{ formErrors['nom_corto_banco'] }}</span>
							</div>
							<div class = 'form-group'>
								<label for = 'nom_banco'>Nombre</label>
								<textarea name = 'nom_banco' class = 'form-control input-sm' v-model = 'newBanco.nom_banco'></textarea>
								<span v-if = "formErrors['nom_banco']" class = 'error text-danger'>@{{ formErrors['nom_banco'] }}</span>
							</div>
							<div class = 'form-group'>
								<button type = 'submit' class = 'btn btn-sm btn-outline btn-primary'><i class = 'fa fa-floppy-o'></i> Guardar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal para editar la informacion de un banco -->
		<div class = 'modal fade' id = 'edit-banco' tabindex = '-1' role = 'dialog' aria-labelledby = 'myModalLabel'>
			<div class = 'modal-dialog' role = 'document'>
				<div class = 'modal-content'>
					<div class = 'modal-header'>
						<button type = 'button' class = 'close' data-dismiss = 'modal' aria-label = 'Close'><span aria-hidden = 'true'>×</span></button>
						<h4 class = 'modal-title' id = 'myModalLabel'><i class =' fa fa-edit'></i> Editar Banco</h4>
					</div>
					<div class = 'modal-body'>
						<form method = 'POST' enctype = 'multipart/form-data' v-on:submit.prevent = 'updateBanco(fillBanco.id_banco)'>
						<div class = 'form-group'>
							<label for = 'title'>Clave de Banco</label>
							<input type = 'text' name = 'cve_banco' class = 'form-control input-sm' v-model = 'fillBanco.cve_banco'/>
							<span v-if = "formErrorsUpdate['cve_banco']" class = 'error text-danger'>@{{ formErrorsUpdate['cve_banco'] }}</span>
						</div>
						<div class = 'form-group'>
							<label for = 'title'>Nombre Corto</label>
							<input type = 'text' name = 'nom_corto_banco' class = 'form-control input-sm' v-model = 'fillBanco.nom_corto_banco'/>
							<span v-if = "formErrorsUpdate['nom_corto_banco']" class = 'error text-danger'>@{{ formErrorsUpdate['nom_corto_banco'] }}</span>
						</div>
						<div class = 'form-group'>
							<label for = 'title'>Nombre</label>
							<textarea name = 'nom_banco' class = 'form-control input-sm' v-model = 'fillBanco.nom_banco'></textarea>
							<span v-if = "formErrorsUpdate['nom_banco']" class = 'error text-danger'>@{{ formErrorsUpdate['nom_banco'] }}</span>
						</div>
						<div class = 'form-group'>
							<button type = 'submit' class = 'btn btn-sm btn-outline btn-success'><i class = 'fa fa-floppy-o'></i> Guardar</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-xs-12 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 margin-tb'>
				<div class = 'pull-right form-group'>
					<button type = 'button' class = 'btn btn-sm btn-outline btn-success' data-toggle = 'modal' data-target = '#create-banco'><i class = 'fa fa-plus-square'></i> Alta Banco</button>
				</div>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-xs-12 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6'>
				<div class = 'table-responsive'>
					<table class = 'table table-bordered table-hover table-condensed'>
						<thead>
							<th>CLAVE</th>
							<th>NOMBRE CORTO</th>
							<th>NOMBRE</th>
							<th>EDITAR</th>
							<th>BORRAR</th>
						</thead>
						<tbody>
							<tr v-for = 'banco in bancos'>
								<td>@{{banco.cve_banco}}</td>
								<td>@{{banco.nom_corto_banco}}</td>
								<td>@{{banco.nom_banco}}</td>
								<td><button class = 'btn btn-sm btn-outline btn-primary' @click.prevent = "editBanco(banco)"><i class = 'fa fa-edit'></i></button></td>
								<td><button class = 'btn btn-sm btn-outline btn-danger' @click.prevent="deleteBanco(banco)"><i class = 'fa fa-times-circle'></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-xs-12 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6'>
				<nav>
					<ul class = 'pagination'>
						<li v-if = 'pagination.current_page > 1'><a href = '#' aria-label = 'Anterior' @click.prevent="changePage(pagination.current_page - 1)"><span aria-hidden = 'true'>«</span></a></li>
						<li v-for = 'page in pagesNumber' v-bind:class = "[ page == isActived ? 'active' : '']"><a href = '#' @click.prevent="changePage(page)">@{{page}}</a></li>
						<li v-if = 'pagination.current_page < pagination.last_page'><a href = '#' aria-label = 'Siguiente' @click.prevent="changePage(pagination.current_page + 1)"><span aria-hidden = 'true'>»</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
@stop

@section('extra_js')
	<script type = 'text/javascript'>
		Vue.http.headers.common['X-CSRF-TOKEN'] = $('#token').attr('value');
		new Vue({
			el: '#manage-bancos',
			data:{
				bancos: [],
				pagination:{
					total: 0, 
					per_page: 2,
					from: 1, 
					to: 0,
					current_page: 1
				},
				offset: 4,
				formErrors:{},
				formErrorsUpdate:{},
				newBanco:{'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':''},
				fillBanco:{'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':'', 'id_banco':''}
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
				this.getBancos(this.pagination.current_page);
			},
			methods: {
				getBancos: function(page){
					this.$http.get('crud-bancos?page='+page).then((response)=>{
						this.$set('bancos', response.data.data.data);
						this.$set('pagination', response.data.pagination);
					});
				},
				createBanco: function(){
					var input = this.newBanco;
					this.$http.post('crud-bancos',input).then((response)=>{
						this.changePage(this.pagination.current_page);
						this.newBanco = {'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':''};
						$('#create-banco').modal('hide');
						toastr.success('Registro dado de alta con exito', '¡Éxito!', {timeOut: 5000});
					}, (response)=>{
						this.formErrors = response.data;
					});
				},
				deleteBanco: function(banco){
					this.$http.delete('crud-bancos/'+banco.id_banco).then((response)=>{
						this.changePage(this.pagination.current_page);
						toastr.success('Registro borrado con éxito.', '¡Éxito!', {timeOut: 5000});
					});
				},
				editBanco: function(banco){
					this.fillBanco.id_banco = banco.id_banco;
					this.fillBanco.cve_banco = banco.cve_banco;
					this.fillBanco.nom_corto_banco = banco.nom_corto_banco;
					this.fillBanco.nom_banco = banco.nom_banco;
					$('#edit-banco').modal('show');
				},
				updateBanco: function(id_banco){
					var input = this.fillBanco;
					this.$http.put('crud-bancos/'+id_banco,input).then((response)=>{
						this.changePage(this.pagination.current_page);
						this.fillBanco = {'cve_banco':'', 'nom_corto_banco':'', 'nom_banco':'', 'id_banco':''};
						$('#edit-banco').modal('hide');
						toastr.success('Registro actualizado con éxito', '¡Éxito!', {timeOut: 5000});
					}, (response)=>{
						this.formErrorsUpdate = response.data;

						toastr.warning('Se presentaron los siguientes errores al intentar actualizar el regitro', '¡Precaución!', {timeOut: 5000});
					});
				},
				changePage: function (page){
					this.pagination.current_page = page;
					this.getBancos(page);
				}
			}
		});
	</script>
@stop