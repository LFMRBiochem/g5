@extends('layout.app')
@section('content')
<!--plugin para la creacion del arbol-->
<link href="{{ asset('treeview/css/bootstrap-treeview.css') }}" rel="stylesheet">
<link href="{{ asset('select2-4.0.3/dist/css/select2.min.css') }}" rel="stylesheet">


<style>
    .panel-default-transparente{
        background: rgba(255,254,240,0.3);
        border: 0px;

    }

    .well{
        background: rgba(34,34,34,0.2);
        border: 1px solid rgba(245,245,245,0.2);

    }

    li {
        list-style-type: none
    }

    .table-borderless > tbody > tr > td,
    .table-borderless > tbody > tr > th,
    .table-borderless > tfoot > tr > td,
    .table-borderless > tfoot > tr > th,
    .table-borderless > thead > tr > td,
    .table-borderless > thead > tr > th {
        border: none;
    }
</style>

<div class="form-group row add">
    <div class="page-header">
        <h1 class="elegantshadow">Catalogo de cuentas</h1>
    </div>
</div>

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-heading" style="background: rgba(245,245,245,0.5);border: 0px"><a><strong><i class="fa fa-columns" aria-hidden="true"></i> Cuentas</strong></a></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                    <!--Lugar donde se despliega el arbol-->
                    <div id="treeview-selectable" class=""></div>
                </div>
                <div class="col-sm-4">
                    <blockquote style="background: rgba(245,245,245,0.5); border-color: rgb(69,182,173)">
                        <p><i class="fa fa-exclamation-circle text-primary" aria-hidden="true"></i> Seleccione una cuenta para modificarlo y/o agregar una nueva sección. </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar descripcion</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Agregar</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a></li>
                </ul>
                <br>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group">
                            <label>Cuenta contable <small>(nuevo)</small></label>
                            <input type="text" class="form-control" id="cuenta_contable" placeholder="Cuenta contable">
                            <p id="error_cuenta_contable" class="text-danger"></p>
                        </div>
                        <div class="form-group">
                            <label id="label_descripcion"></label>
                            <input type="text" class="form-control" id="descripcion" placeholder="Descripcion">
                            <p id="error_descripcion" class="text-danger"></p>
                        </div>
                        <div>
                            <label>Naturaleza</label>
                            <select id="naturaleza" style="width: 100%">
                                <option value="D">Deudora</option>
                                <option value="A">Acreedora</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="text-right">
                                <button type="submit" id="guardar_descripcion" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar</button>

                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" class="form-control" id="cuenta_contable_edit">
                                <p id="error_cuenta_contable_edit" class="text-danger"></p>
                            </div>
                            <div class="form-group">
                                <label id="label_descripcion_editar"></label>
                                <input type="text" class="form-control" id="descripcion_edit">
                                <p id="error_descripcion_edit" class="text-danger"></p>
                            </div>
                            <div class="form-group">
                                <label>Cambiar descripcion padre</label>
                                <select id="select_descripcion"  class="js-example-data-array" style="width: 100%">
                                </select>
                            </div>
                            <div>
                                <label>Naturaleza</label>
                                <select id="naturaleza_edit" style="width: 100%">
                                    <option></option>
                                    <option value="D">Deudora</option>
                                    <option value="A">Acreedora</option>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="text-right">         
                                    <button type="submit" id="editar_descripcion" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('javascript')
<!--scrips para crear el arbol y el script para el select2-->
<script type="text/javascript" src="{{ asset('treeview/js/bootstrap-treeview_cat_cuentas.js') }}"></script>
<script type="text/javascript" src="{{ asset('select2-4.0.3/dist/js/select2.full.min.js') }}"></script>



<script>

var json = [];
var id = null;

$(document).ready(function () {

//inicializamos los select2
    $("#naturaleza").select2( );
    $("#naturaleza_edit").select2();

//iniciamos el metodo para obtener las cuentas de ctb_cat_cuentas
    get_cuentas();

// data es el json donde estan cargados todos los datos para la creacion del arbol 
    function iniciar(data) {
        var initSelectableTree = [];
        initSelectableTree = function () {
            return $('#treeview-selectable').treeview({
                data: data,
                expanded: true,
                levels: 99,
                onNodeSelected: function (event, node) {
                    limpiar_datos();
//                    Agregar
                    $('#label_descripcion').html('Agregar sub-descripcion a ' + node.text.split("|").join(" "));
                    $('#descripcion').val('');
                    $('#naturaleza').val(node.naturaleza).change();

//                    Modificar
                    $('#cuenta_contable_edit').val(node.cuenta_contable);
                    $('#descripcion_edit').val(node.text);
                    $('#label_descripcion_editar').html('Modificar descripcion ' + node.text.split("|").join(" "));
                    $('#descripcion_edit').val(node.text.split("|").join(" "));
                    $('#select_descripcion').val(node.id_cuenta_padre).change();
                    $('#naturaleza_edit').val(node.naturaleza).change();

                    id = node.id;
//                    cultamos el modal
                    $('#myModal').modal('show');
                },
                onNodeUnselected: function (event, node) {
                    $('#label_descripcion').val('');
                    id = null;
                }
            });
        };
//        iniciamos la creacion del arbol
        initSelectableTree();
    }

    function get_cuentas() {

        toastr.success('Cargando información.', 'Espere...');
//vamos a la ruta donde se encuentra la query de ctb_cat_cuentas por el metodo get
        $.get("ctb_cat_cuentas/get_cuentas", function (data) {

            $(".js-example-data-array").select2({
                data: data
            });
//            con este metodo se crea la estructura gerarquica del arbol
            json = convert(data);
//            iniciamos la estructura del arbol desde este metodo pasandole el json
            iniciar(json);
        });
        toastr.clear();
    }
//funcion para acomodar el arbol
    function convert(array) {
        var map = {};
        for (var i = 0; i < array.length; i++) {
            var obj = array[i];
            obj.nodes = [];

            map[obj.id] = obj;
            var parent = obj.id_cuenta_padre || '-';
            if (!map[parent]) {
                map[parent] = {
                    nodes: []
                };
            }
            map[parent].nodes.push(obj);
        }
        return map['-'].nodes;
    }
//limpiamos los campos de errores
    function limpiar_datos() {
        $("#error_descripcion").html('');
        $("#error_descripcion_edit").html('');
        $("#error_cuenta_contable").html('');
        $("#error_cuenta_contable_edit").html('');
    }

    $("#guardar_descripcion").click(function () {
        limpiar_datos();

        var descripcion = $("#descripcion").val();
        var cuenta_contable = $("#cuenta_contable").val();
        var naturaleza = $('#naturaleza').val();
//mandamos guardar por el metodo post
        $.post("ctb_cat_cuentasC", {
            cuenta_contable: cuenta_contable,
            descripcion: descripcion,
            naturaleza: naturaleza,
            id_cuenta_padre: id,
            _token: '{{ csrf_token() }}'}
        )
                .done(function () {
                    //si es exitoso llama a las cuentas para acomodar el arbol de nuevo
                    get_cuentas();
                    $('#myModal').modal('hide');
                })
                .fail(function (data) {
//                    mostramos los errores de validacion
                    var errors = JSON.parse(data.responseText);
                    $("#error_cuenta_contable").html(errors.cuenta_contable);
                    $("#error_descripcion").html(errors.descripcion);
                    $("#error_naturaleza").html(errors.naturaleza);

                });
    });

    $("#editar_descripcion").click(function () {
        limpiar_datos();

        var descripcion = $("#descripcion_edit").val();
        var cuenta_contable = $("#cuenta_contable_edit").val();
        var select_descripcion = $('#select_descripcion').val();
        var naturaleza = $('#naturaleza_edit').val();

//editamos las cuentas por metodo post
        $.post("ctb_cat_cuentas/get_cuentas/" + id, {
            cuenta_contable: cuenta_contable,
            descripcion: descripcion,
            id_cuenta_padre: select_descripcion,
            naturaleza: naturaleza,
            _token: '{{ csrf_token() }}'}
        )
                .done(function () {
                    get_cuentas();
                    $('#myModal').modal('hide');
                })
                .fail(function (data) {
                    var errors = JSON.parse(data.responseText);
                    $("#error_cuenta_contable_edit").html(errors.cuenta_contable);
                    $("#error_descripcion_edit").html(errors.descripcion);
                });
    });

});
</script>

@stop
