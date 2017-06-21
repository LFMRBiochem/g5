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
                    <li role="presentation" class="active"><a href="#panel_agregar" aria-controls="panel_agregar" role="tab" data-toggle="tab">Agregar</a></li>
                    <li role="presentation"><a href="#panel_modificar" aria-controls="panel_modificar" role="tab" data-toggle="tab">Modificar</a></li>
                    <li role="presentation" id="hidden_panel_asociaciones"><a href="#panel_asociaciones" aria-controls="panel_asociaciones" role="tab" data-toggle="tab">Asociaciones</a></li>
                </ul>
                <br>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="panel_agregar">
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

                    <div role="tabpanel" class="tab-pane" id="panel_modificar">
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

                    <div role="tabpanel" class="tab-pane" id="panel_asociaciones">
                        <div class="form-group">
                            <label>Tipo centros de costo</label>
                            <select id="tipos_centros_costo_editar" class="js-example-basic-hide-search form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </div>
                        <div id="treeview-selectable_elementos_editar"></div>
                        <hr>
                        <div class="form-group">
                            <label>Conceptos financieros </label>
                            <select id="conceptos_financieros_editar" class="js-example-basic-multiple" multiple="multiple" style="width: 100%">
                                <option></option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="text-right">         
                                <button type="submit" id="editar_asociaciones" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar</button>
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
// json para el catalogo de cuentas
var json = [];
var id = null;
// json para areas y departamentos que estamos llamando elementos
var json_elementos = [];
var id_elementos = null;
var centros_costo_change = null;

var centros_costo_editar = [];
var concepto_financiero = null;

$(document).ready(function () {

// inicializamos los select2
    $("#naturaleza").select2();
    $("#naturaleza_edit").select2();
    $("#tipo_centro_costo").select2({placeholder: 'Tipo centro de costo', minimumResultsForSearch: Infinity});

// iniciamos el metodo para obtener las cuentas de ctb_cat_cuentas
    get_cuentas();
    get_tipos_centros_costo_editar();
    get_conceptos_financieros_editar();

    // inicializa el arbol de las areas y departamentos (elementos) en editar
    function iniciar_editar(data) {
        $('#treeview-selectable_elementos_editar').treeview({
            data: data,
            expanded: true,
            levels: 2,
            showCheckbox: true,
            onNodeChecked: function (event, node) {
//                check los hijos
                check_node_elemento_editar(node);
            },
            onNodeUnchecked: function (event, node) {
//                uncheck los hijos
                uncheck_node_elemento_editar(node);
            }
        });
    }

    $("#tipos_centros_costo_editar").change(function () {
//        obligatorio que el if tenga el espacio en blanco si no no lo reconoce el pluggin de select2
        if ($("#tipos_centros_costo_editar").val() != ' ') {
            if ($("#tipos_centros_costo_editar").val() != null) {
//            Tipo de centro costo DEP por ejemplo
                centros_costo_change = $("#tipos_centros_costo_editar").val();
                get_elementos_editar(centros_costo_change);
                get_asociaciones_edit(id, centros_costo_change);
            }
        }
    });

    function get_asociaciones_edit(id_cuenta, cve_tipoCentroCosto) {
        var id_conceptofinanciero = [];
        $.get("ctb_cat_cuentas/asociaciones_edit/conceptofinanciero/" + id_cuenta + '/' + cve_tipoCentroCosto, function (data) {
            $(data).each(function (i, element) {
                id_conceptofinanciero.push(element.id_conceptofinanciero);
            });
            $("#conceptos_financieros_editar").val(id_conceptofinanciero).trigger("change");
        });
        $.get("ctb_cat_cuentas/asociaciones_edit/centros_costo/" + id_cuenta, function (data) {
            centros_costo_editar = data;
        });
    }

    function get_tipos_centros_costo_editar() {
        $.get("ctb_cat_cuentas/tipos_centros_costo", function (data) {
            $("#tipos_centros_costo_editar").append('<option value=" "> </option>');
            $(data).each(function (i, fila) {
                $("#tipos_centros_costo_editar").append('<option value="' + fila.cve_tipoCentroCosto + '">' + fila.tipo_cc + '</option>');
            });
            $("#tipos_centros_costo_editar").select2({placeholder: 'Conceptos financieros'});
        });
    }


    function get_conceptos_financieros_editar(cve_tipoCentroCosto) {
        $.get("ctb_cat_cuentas/conceptos_financieros", function (data) {
            $(data).each(function (i, fila) {
                $("#conceptos_financieros_editar").append('<option value="' + fila.id_conceptofinanciero + '">' + fila.nombre_concepto + '</option>');
            });
            $("#conceptos_financieros_editar").select2({placeholder: 'Conceptos financieros', minimumResultsForSearch: Infinity});
        });
    }

    function get_elementos_editar(cve_tipoCentroCosto) {
        toastr.success('Cargando información.', 'Espere...');
        $.get("ctb_cat_cuentas/centros_costo/" + cve_tipoCentroCosto, function (data) {
            json_elementos = convert_elemento(data);
            json_elementos = limpiar_nodes(json_elementos);
            json_elementos = check(json_elementos);
            iniciar_editar(json_elementos);
        });
        toastr.clear();
    }

    function check(data) {
        $(data).each(function (i, element) {
            if (element.nodes && element.nodes.length > 0) {
                check(element.nodes);
            } else {
                $(centros_costo_editar).each(function (j, fila) {
                    if (fila.id_centrocosto === element.id_centrocosto) {
                        element.state = {checked: true};
                    }
                });
            }
        });
        return data;
    }

// data es el json donde estan cargados todos los datos para la creacion del arbol 
    function iniciar_arbol_cuentas() {
        $('#treeview-selectable').treeview({
            data: json,
            expanded: true,
            levels: 2,
            onNodeSelected: function (event, node) {

                limpiar_datos_cuentas();
//              Agregar
                $('#label_descripcion').html('Agregar sub-descripcion a ' + node.text.split("|").join(" "));
                $('#descripcion').val('');
                $('#naturaleza').val(node.naturaleza).change();

//              Modificar
                $('#cuenta_contable_edit').val(node.cuenta_contable);
                $('#descripcion_edit').val(node.text);
                $('#label_descripcion_editar').html('Modificar descripcion ' + node.text.split("|").join(" "));
                $('#descripcion_edit').val(node.text.split("|").join(" "));
                $('#select_descripcion').val(node.id_cuenta_padre).change();
                $('#naturaleza_edit').val(node.naturaleza).change();

                id = node.id;
                if ("undefined" === typeof node.nodes) {
                    $('#hidden_panel_asociaciones').show();
                } else {
                    $('#hidden_panel_asociaciones').hide();
                }
                $('#myModal').modal('show');
            },
            onNodeUnselected: function (event, node) {
                $('#label_descripcion').val('');
                id = null;
            },
            onNodeChecked: function (event, node) {
//                check los hijos
                check_node(node);
            },
            onNodeUnchecked: function (event, node) {
//                uncheck los hijos
                uncheck_node(node);
            }
        });
    }

    $("#guardar_descripcion").click(function () {
        limpiar_datos_cuentas();
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
//                  mostramos los errores de validacion
                    var errors = JSON.parse(data.responseText);
                    $("#error_cuenta_contable").html(errors.cuenta_contable);
                    $("#error_descripcion").html(errors.descripcion);
                    $("#error_naturaleza").html(errors.naturaleza);
                });
    });

    $("#editar_descripcion").click(function () {
        limpiar_datos_cuentas();

        var descripcion = $("#descripcion_edit").val();
        var cuenta_contable = $("#cuenta_contable_edit").val();
        var select_descripcion = $('#select_descripcion').val();
        var naturaleza = $('#naturaleza_edit').val();

//      editamos las cuentas por metodo post
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

    $("#editar_asociaciones").click(function () {
        var elementos = [];
        var conceptos_financieros = [];

        elementos = $('#treeview-selectable_elementos_editar').treeview('getChecked');
        conceptos_financieros = $('#conceptos_financieros_editar').val();

        var cuentas_id_cuenta = id;
        var elementos_id_centrocosto = [];
        var cuentas_id_conceptofinanciero = [];

        $(elementos).each(function (k, fila_elementos) {
            if (fila_elementos.nodes == null) {
                elementos_id_centrocosto.push(fila_elementos.id_centrocosto);
            }
        });
        $(conceptos_financieros).each(function (j, fila_conceptos_financieros) {
            cuentas_id_conceptofinanciero.push(fila_conceptos_financieros);
        });

        $.post("ctb_cat_cuentas/editar_asociaciones/" + cuentas_id_cuenta + '/' + centros_costo_change, {
            _token: '{{ csrf_token() }}',
            id_centrocosto: elementos_id_centrocosto,
            id_conceptofinanciero: cuentas_id_conceptofinanciero,
        })
                .done(function (data) {
                    get_cuentas();
                    $('#myModal').modal('hide');
                })
                .fail(function (data) {

                });
    });

    function check_node_elemento_editar(data) {
        $(data).each(function (i, element) {
            $('#treeview-selectable_elementos_editar').treeview('checkNode', [element.nodeId, {silent: true}]);
            if (element.nodes && element.nodes.length > 0) {
                check_node_elemento_editar(element.nodes);
            }
        });
    }

    function uncheck_node_elemento_editar(data) {
        $(data).each(function (i, element) {
            $('#treeview-selectable_elementos_editar').treeview('uncheckNode', [element.nodeId, {silent: true}]);
            if (element.nodes && element.nodes.length > 0) {
                uncheck_node_elemento_editar(element.nodes);
            }
        });
    }

    function check_node(data) {
        $(data).each(function (i, element) {
            $('#treeview-selectable').treeview('checkNode', [element.nodeId, {silent: true}]);
            if (element.nodes && element.nodes.length > 0) {
                check_node(element.nodes);
            }
        });
    }

    function uncheck_node(data) {
        $(data).each(function (i, element) {
            $('#treeview-selectable').treeview('uncheckNode', [element.nodeId, {silent: true}]);
            if (element.nodes && element.nodes.length > 0) {
                uncheck_node(element.nodes);
            }
        });
    }

    function get_cuentas() {
        toastr.success('Cargando información.', 'Espere...');
//      vamos a la ruta donde se encuentra la query de ctb_cat_cuentas por el metodo get
        $.get("ctb_cat_cuentas/get_cuentas", function (data) {
            $(".js-example-data-array").select2({
                data: data
            });
//          con este metodo se crea la estructura gerarquica del arbol
            json = convert(data);
            json = limpiar_nodes(json);
//          iniciamos la estructura del arbol desde este metodo pasandole el json
            iniciar_arbol_cuentas();
        });
        toastr.clear();
    }

    function limpiar_nodes(data) {
        $(data).each(function (i, element) {
            if (element.nodes.length === 0) {
                delete(element.nodes);
            }
            if (element.nodes && element.nodes.length > 0) {
                limpiar_nodes(element.nodes);
            }
        });
        return data;
    }

    function convert_elemento(array) {
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
    function limpiar_datos_cuentas() {
        $("#error_descripcion_edit").html('');
        $("#error_cuenta_contable_edit").html('');
        $('#treeview-selectable_elementos_editar').empty();
        $('.js-example-basic-multiple').val(null).trigger("change");
        $('.js-example-basic-hide-search').val(' ').trigger("change");
    }

});
</script>

@stop