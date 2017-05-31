@extends('layout.app')
@section('content')
<link href="{{ asset('treeview/css/bootstrap-treeview.css') }}" rel="stylesheet">

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
        <h1>Catalogo de departamentos y áreas</h1>
    </div>
</div>

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div id="treeview-selectable" class=""></div>
                </div>
                <div class="col-sm-6">
                    <div id="collapseExample">
                        <div class="form-group">
                            <label id="label_departamento"></label>
                            <input type="text" class="form-control" id="departamento" placeholder="Departamento">
                        </div>
                        <div class="form-group">
                            <div class="text-right">
                                <button type="submit" id="guardar_departamento" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
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
                    $('#label_departamento').html('Agregar rama a ' + node.text.split("|").join(" "));
                    id = node.id;
                    collapse();
                },
                onNodeUnselected: function (event, node) {
                    $('#label_departamento').html('Agregar');
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


    $("#guardar_departamento").click(function () {
        var departamento = $("#departamento").val().toUpperCase();
        $.post("nmn_cat_departamentosC",
                {
                    nombre_centrocosto: departamento,
                    id_centrocosto_padre: id,
                    _token: '{{ csrf_token() }}'

                },
                function (data, status) {
                    if (status === 'success') {
                        findObj(json, id).nodes.push({text: departamento, id: data, nodes: []});
                        iniciar(json);
                    }
                }
        );



    });

    function findObj(data, id) {
        for (var i in data) {
            if (i == 'id' && data[i] == id) {
                return data;
            }
            if (typeof data[i] == 'object' && findObj(data[i], id)) {
                return findObj(data[i], id);
            }
        }
    }



});
</script>

@stop
