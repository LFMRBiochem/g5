@extends('layout.app')
@section('content')
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
        <h1 class="elegantshadow">Catalogo de departamentos y áreas</h1>
    </div>
</div>

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-heading" style="background: rgba(245,245,245,0.5);border: 0px"><a><strong><i class="fa fa-columns" aria-hidden="true"></i> Departamentos y áreas</strong></a></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div id="treeview-selectable" class=""></div>
                </div>
                <div class="col-sm-6">

                    <blockquote style="background: rgba(245,245,245,0.5); border-color: rgb(69,182,173)">
                        <p><i class="fa fa-exclamation-circle text-primary" aria-hidden="true"></i> Seleccione un área o departamento para modificarlo y/o agregar una nueva sección. </p>
                    </blockquote>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <div id="collapseExample">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Agregar</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a></li>
                    </ul>
                    <br>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="form-group">
                                <label id="label_departamento"></label>
                                <input type="text" class="form-control" id="departamento" placeholder="Departamento">
                                <p id="error_departamento" class="text-danger"></p>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="text-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" id="guardar_departamento" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="form-group">
                                    <label id="label_departamento_editar"></label>
                                    <input type="text" class="form-control" id="departamento_edit">
                                    <p id="error_departamento_edit" class="text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>Cambiar departamento de rama principal</label>
                                    <select id="select_departamento"  class="js-example-data-array" style="width: 100%">
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" id="editar_departamento" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                    </div>
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
<script type="text/javascript" src="{{ asset('treeview/js/bootstrap-treeview.js') }}"></script>
<script type="text/javascript" src="{{ asset('select2-4.0.3/dist/js/select2.full.min.js') }}"></script>



<script>

var json = [];
var id = null;
$(document).ready(function () {

    get_departamentos();

    function iniciar(data) {
        document.getElementById('collapseExample').style.display = 'none';
        var initSelectableTree = [];
        initSelectableTree = function () {
            return $('#treeview-selectable').treeview({
                data: data,
                expanded: true,
                levels: 99,
                onNodeSelected: function (event, node) {
                    limpiar_datos();
                    $('#label_departamento').html('Agregar rama a ' + node.text.split("|").join(" "));
                    $('#label_departamento_editar').html('Editar rama ' + node.text.split("|").join(" "));
                    $('#departamento_edit').val(node.text);
                    $('#select_departamento').val(node.id_centrocosto_padre).change();
                    $('#departamento').val('');
                    id = node.id;
                    collapse();
                    $('#myModal').modal('show');
                },
                onNodeUnselected: function (event, node) {
                    $('#label_departamento').val('');
                    id = null;
                    collapse();
                }
            });
        };
        initSelectableTree();
    }

    function collapse() {
        var x = document.getElementById('collapseExample');
        if (id === null) {
            x.style.display = 'none';
        } else {
            x.style.display = 'block';
        }
    }

    function get_departamentos() {
        $.get("nmn_cat_departamentos/departamentos", function (data) {
            $(".js-example-data-array").select2({
                data: data
            })
            json = convert(data);
            iniciar(json);
        });
    }

    function convert(array) {

        var map = {};
        for (var i = 0; i < array.length; i++) {
            var obj = array[i];
            obj.nodes = [];

            map[obj.id_centrocosto] = obj;
            var parent = obj.id_centrocosto_padre || '-';
            if (!map[parent]) {
                map[parent] = {
                    nodes: []
                };
            }
            map[parent].nodes.push(obj);
        }
        return map['-'].nodes;
    }

    function limpiar_datos() {
        $("#error_departamento").html('');
        $("#error_departamento_edit").html('');
    }

    $("#guardar_departamento").click(function () {
        limpiar_datos();
        var departamento = $("#departamento").val().toUpperCase();
        $.post("nmn_cat_departamentosC", {
            nombre_centrocosto: departamento,
            id_centrocosto_padre: id,
            _token: '{{ csrf_token() }}'}
        )
                .done(function () {
                    get_departamentos();
                })
                .fail(function (data) {
                    var errors = JSON.parse(data.responseText);
                    $("#error_departamento").html(errors.nombre_centrocosto);
                });
    });

    $("#editar_departamento").click(function () {
        limpiar_datos();
        var departamento = $("#departamento_edit").val().toUpperCase();
        var select_departamento = $('#select_departamento').val();
        $.post("nmn_cat_departamentos/editar_departamento/" + id, {
            nombre_centrocosto: departamento,
            id_centrocosto: select_departamento,
            _token: '{{ csrf_token() }}'}
        )
                .done(function () {
                    get_departamentos();
                })
                .fail(function (data) {
                    var errors = JSON.parse(data.responseText);
                    $("#error_departamento_edit").html(errors.nombre_centrocosto);
                });
    });

});
</script>

@stop
