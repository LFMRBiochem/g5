@extends('main')
@section('title')
	Árbol de Cuentas
@stop
@section('extra_css')
	<style type = 'text/css'>
		.tree {
			min-height:20px;
			padding:19px;
			margin-bottom:20px;
			background-color:#fbfbfb;
			border:1px solid #999;
			-webkit-border-radius:4px;
			-moz-border-radius:4px;
			border-radius:4px;
			-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
			-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
			box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
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
			border-left:1px solid #999;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #999;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border:1px solid #999;
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
	</style>
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
	CATALOGO DE CUENTAS CONTABLES
@stop
@section('report')
	<div class = 'panel-body' id = 'arbol'>
		<div class = 'row'>
			<div class = 'col-xs-6'>
				<ul class = 'tree'>
					<item class = 'item' :model = 'treeData'></item>
				</ul>
			</div>
		</div>
	</div>
	<!-- Template para el componente del arbol -->
	<script type='text/x-template' id = 'item-template'>
		<li>
			<div :class = '{bold: isFolder}' @click = 'toggle'>
				<span v-if = 'isFolder'><i v-if = 'open' class = 'fa fa-folder-open-o'></i><i v-else class = 'fa fa-folder-o'></i> @{{model.cuenta_contable}} @{{model.name}}</span>
				<span v-else><i class = 'fa fa-leaf'></i></i> @{{model.cuenta_contable}} @{{model.name}}</span>
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
				toggle: function () {
					if (this.isFolder) {
						this.open = !this.open
					}
				}
			}
		})
		new Vue({
			el: '#arbol',
			data: {
				treeData: {name: 'Catálogo de Cuentas'}
			},
			ready: function(){
				this.getCuentas();
			},
			methods: {
				getCuentas: function(){
					this.$http.get('catalogo-de-cuentas-contables').then((response)=>{
						this.$set('treeData', response.data);
					});
				}
			}
		})
	</script>
@stop