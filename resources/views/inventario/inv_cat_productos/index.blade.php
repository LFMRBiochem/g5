@extends('layout.app')
@section('content')
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
        <h1>Inventario productos</h1>
    </div>

    <div class="col-md-12">
        <div id="evento">
            <div class="text-right">
                <button type="button"  data-toggle="modal" data-target="#create-item"  v-on:click="iniciarCrear()" class="btn btn-primary" @keydown.enter.prevent="">
                    <i class="fa fa-plus" aria-hidden="true"></i> Crear
                </button>
            </div>
        </div>
    </div>
</div>

<div id="listar">

    <div class="row">
        <div class="panel panel-default-transparente">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr style="background: rgba(245,245,245,0.5);border: 0px">
                            <th>Clave del producto</th>
                            <th>Nombre del producto</th>
                            <th>Usos</th>
                            <th>Dosis</th>
                            <th>Acciones</th>
                        </tr>
                        <tr v-for="item in items">
                            <td>@{{ item.cve_producto }}</td>
                            <td>@{{ item.nombre_producto }}</td>
                            <td>@{{ item.usos }}</td>
                            <td>@{{ item.dosis }}</td>
                            <td>
                                <div id="eventoEditar">
                                    <button class="edit-modal btn btn-warning btn-sm" @click.prevent="editItem(item)">
                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                    </button>
                                </div>
                                <button class="edit-modal btn btn-danger btn-sm" @click.prevent="deleteItem(item)">
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <nav>
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#" @click.prevent="changePage(page)">
                        @{{ page }}
                    </a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>


    <!--Edit Item Modal-->
    <div class="modal fade" id="edit-item" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar producto</h4>
                </div>
                <div class="modal-body">
                    <div id="editar">
                        <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.cve_cat_producto)" @keydown.enter.prevent="">

                            <div class="form-group">
                                <label for="cve_producto">Clave del producto:</label>
                                <input type="text" class="form-control" v-model="fillItem.cve_producto" autocomplete="off">
                                <span v-if="formErrors['cve_producto']" class="error text-danger">
                                    @{{ formErrors['cve_producto'] }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="nombre_producto">Nombre producto:</label>
                                <input type="text" class="form-control" v-model="fillItem.nombre_producto" autocomplete="off">
                                <span v-if="formErrors['nombre_producto']" class="error text-danger">
                                    @{{ formErrors['nombre_producto'] }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="usos">Usos:</label>
                                <input type="text" class="form-control" v-model="fillItem.usos" autocomplete="off">
                                <span v-if="formErrors['usos']" class="error text-danger">
                                    @{{ formErrors['usos'] }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="dosis">Dosis:</label>
                                <textarea class="form-control" v-model="fillItem.dosis"></textarea>
                                <span v-if="formErrors['dosis']" class="error text-danger">
                                    @{{ formErrors['dosis'] }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="ventajas">Ventajas:</label>
                                <textarea class="form-control" v-model="fillItem.ventajas"></textarea>
                                <span v-if="formErrors['ventajas']" class="error text-danger">
                                    @{{ formErrors['ventajas'] }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="formula">Formula:</label>
                                <textarea class="form-control" v-model="fillItem.formula"></textarea>
                                <span v-if="formErrors['formula']" class="error text-danger">
                                    @{{ formErrors['formula'] }}
                                </span>
                            </div>

                            <hr>

                            <h4 class="text-center">Agregar identificador comercial</h4>

                            <div v-for="cont in fillItem.contador">
                                <div v-if="fillItem.guardar[cont] == 1">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6"><p>GTIN #@{{cont}} </p></div>
                                        <div v-if="fillItem.folio_GTIN[cont] > 1">
                                        </div>
                                        <div v-else-if="fillItem.folio_GTIN[cont] === 'no'">
                                            <div class="col-md-6" v-if="cont != 1"><p class="text-right"><a class="text-danger" v-on:click="noGuardar(cont)"><i class="fa fa-minus-square-o" aria-hidden="true"></i> Borrar</a></p></div>
                                        </div>
                                    </div>
                                    <div v-if='fillItem.estatus[cont] === true'>
                                        <ol class="breadcrumb" v-if="cve.segmento[cont]">
                                            <li v-if="cve.segmento[cont]"><a v-on:click="getSegmento(cont)">@{{nombre.segmento[cont]}}</a></li>
                                            <li v-if="cve.familia[cont]"><a v-on:click="getFamilia(cont,cve.segmento[cont],nombre.segmento[cont])">@{{nombre.familia[cont]}}</a></li>
                                            <li v-if="cve.clase[cont]"><a v-on:click="getClase(cont,cve.familia[cont],nombre.familia[cont])">@{{nombre.clase[cont]}}</a></li>
                                            <li v-if="cve.bloque[cont]"><a v-on:click="getBloque(cont,cve.clase[cont],nombre.clase[cont])">@{{nombre.bloque[cont]}}</a></li>
                                        </ol>
                                        <span v-if="formErrors['gtin.'+cont]" class="error text-danger">
                                            @{{ formErrors['gtin.'+cont] }}
                                        </span>
                                        <div class="list-group" v-if="fillItem.gtin[cont] == ''">
                                            <div v-if="posicion_identificador_comercial[cont] == 1">
                                                <label for="formula">Segmento:</label>
                                                <div class="row">
                                                    <div class="col-md-1 col-sm-1"></div>
                                                    <div class="col-md-10 col-sm-10">
                                                        <a v-for="segmento in productos_segmento[cont]" v-on:click="getFamilia(cont,segmento.cve_segmento,segmento.nombre_segmento)" class="list-group-item">
                                                            @{{ segmento.nombre_segmento }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div v-if="posicion_identificador_comercial[cont] == 2">
                                                <label for="formula">Familia:</label>
                                                <div class="row">
                                                    <div class="col-md-1 col-sm-1"></div>
                                                    <div class="col-md-10 col-sm-10">
                                                        <a v-for="familia in productos_familia[cont]" v-on:click="getClase(cont,familia.cve_familia,familia.nombre_familia)" class="list-group-item">
                                                            @{{ familia.nombre_familia }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div v-if="posicion_identificador_comercial[cont] == 3">
                                                <label for="formula">Clase:</label>
                                                <div class="row">
                                                    <div class="col-md-1 col-sm-1"></div>
                                                    <div class="col-md-10 col-sm-10">
                                                        <a v-for="clase in productos_clase[cont]" v-on:click="getBloque(cont,clase.cve_clase,clase.nombre_clase)" class="list-group-item">
                                                            @{{ clase.nombre_clase }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1"></div>
                                                </div>
                                            </div>
                                            <div v-if="posicion_identificador_comercial[cont] == 4">
                                                <label for="formula">Bloque:</label>
                                                <div class="row">
                                                    <div class="col-md-1 col-sm-1"></div>
                                                    <div class="col-md-10 col-sm-10">
                                                        <a v-for="bloque in productos_bloque[cont]" v-on:click="getAll(cont,bloque.cve_bloque,bloque.nombre_bloque)" class="list-group-item">
                                                            @{{ bloque.nombre_bloque }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="precio_unitario">precio_unitario:</label>
                                            <input type="text" class="form-control"  v-model="fillItem.precio_unitario[cont]" autocomplete="off">
                                            <span v-if="formErrors['precio_unitario.'+cont]" class="error text-danger">
                                                @{{ formErrors['precio_unitario.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="piezas_por_paquete">piezas_por_paquete:</label>
                                            <input type="text" class="form-control"  v-model="fillItem.piezas_por_paquete[cont]" autocomplete="off">
                                            <span v-if="formErrors['piezas_por_paquete.'+cont]" class="error text-danger">
                                                @{{ formErrors['piezas_por_paquete.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="venta_minima">venta_minima:</label>
                                            <input type="text" class="form-control"  v-model="fillItem.venta_minima[cont]" autocomplete="off">
                                            <span v-if="formErrors['venta_minima.'+cont]" class="error text-danger">
                                                @{{ formErrors['venta_minima.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="peso_unitario">peso_unitario:</label>
                                            <input type="text" class="form-control"  v-model="fillItem.peso_unitario[cont]" autocomplete="off">
                                            <span v-if="formErrors['peso_unitario.'+cont]" class="error text-danger">
                                                @{{ formErrors['peso_unitario.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" v-model="fillItem.es_venta[cont]" v-bind:true-value="1" v-bind:false-value="0" value="0"> es_venta
                                                </label>
                                            </div>
                                            <span v-if="formErrors['es_venta.'+cont]" class="error text-danger">
                                                @{{ formErrors['es_venta.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" v-model="fillItem.considerar_margen[cont]" v-bind:true-value="1" v-bind:false-value="0" value="0"> considerar_margen
                                                </label>
                                            </div>
                                            <span v-if="formErrors['considerar_margen.'+cont]" class="error text-danger">
                                                @{{ formErrors['considerar_margen.'+cont] }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="cve_unidad_medida">cve_unidad_medida:</label>
                                            <v-select :options="unidad_medida" v-model="fillItem.cve_unidad_medida[cont]" placeholder="Seleccione..."   >
                                            </v-select>
                                            <span v-if="formErrors['cve_unidad_medida.'+cont]" class="error text-danger">
                                                @{{ formErrors['cve_unidad_medida.'+cont] }}
                                            </span>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div v-if="fillItem.estatus[cont] == true">
                                            <button type="button" class="btn btn-danger btn-sm" v-on:click="cambiar_estatus(cont,fillItem.estatus[cont])">
                                                <i class="fa fa-toggle-on" aria-hidden="true"></i> Desactivar
                                            </button>
                                        </div>
                                        <div v-else-if="fillItem.estatus[cont] == false">
                                            <button type="button" class="btn btn-success btn-sm" v-on:click="cambiar_estatus(cont,fillItem.estatus[cont])">
                                                <i class="fa fa-toggle-off" aria-hidden="true"></i> Activar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-sm-2"></div>
                                <div class="col-md-8 col-sm-8">
                                    <button type="button" v-on:click="addContador()" class="btn btn-warning btn-sm btn-block">
                                        <i class="fa fa-plus-square-o fa-lg text-center" aria-hidden="true"></i> Agregar GTIN
                                    </button>
                                </div>
                                <div class="col-md-2 col-sm-2"></div>
                            </div>

                            <br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!--Create Item Modal-->
<div class="modal fade" id="create-item" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear producto</h4>
            </div>
            <div class="modal-body">
                <div id="crear">
                    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem" >

                        <div class="form-group">
                            <label for="cve_producto">Clave del producto:</label>
                            <input type="text" class="form-control" v-model="newItem.cve_producto" autocomplete="off">
                            <span v-if="formErrors['cve_producto']" class="error text-danger">
                                @{{ formErrors['cve_producto'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="nombre_producto">Nombre producto:</label>
                            <input type="text" class="form-control" v-model="newItem.nombre_producto" autocomplete="off">
                            <span v-if="formErrors['nombre_producto']" class="error text-danger">
                                @{{ formErrors['nombre_producto'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="usos">Usos:</label>
                            <input type="text" class="form-control" v-model="newItem.usos" autocomplete="off">
                            <span v-if="formErrors['usos']" class="error text-danger">
                                @{{ formErrors['usos'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="dosis">Dosis:</label>
                            <textarea class="form-control" v-model="newItem.dosis"></textarea>
                            <span v-if="formErrors['dosis']" class="error text-danger">
                                @{{ formErrors['dosis'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="ventajas">Ventajas:</label>
                            <textarea class="form-control" v-model="newItem.ventajas"></textarea>
                            <span v-if="formErrors['ventajas']" class="error text-danger">
                                @{{ formErrors['ventajas'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="formula">Formula:</label>
                            <textarea class="form-control" v-model="newItem.formula"></textarea>
                            <span v-if="formErrors['formula']" class="error text-danger">
                                @{{ formErrors['formula'] }}
                            </span>
                        </div>

                        <hr>

                        <h4 class="text-center">Agregar identificador comercial</h4>

                        <div v-for="cont in newItem.contador">
                            <div v-if="newItem.guardar[cont] == true">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6"><p>GTIN #@{{cont}} </p></div>
                                    <div class="col-md-6" v-if="cont != 1"><p class="text-right"><a class="text-danger" v-on:click="noGuardar(cont)"><i class="fa fa-minus-square-o" aria-hidden="true"></i> Borrar</a></p></div>
                                </div>
                                <ol class="breadcrumb" v-if="cve.segmento[cont]">
                                    <li v-if="cve.segmento[cont]"><a v-on:click="getSegmento(cont)">@{{nombre.segmento[cont]}}</a></li>
                                    <li v-if="cve.familia[cont]"><a v-on:click="getFamilia(cont,cve.segmento[cont],nombre.segmento[cont])">@{{nombre.familia[cont]}}</a></li>
                                    <li v-if="cve.clase[cont]"><a v-on:click="getClase(cont,cve.familia[cont],nombre.familia[cont])">@{{nombre.clase[cont]}}</a></li>
                                    <li v-if="cve.bloque[cont]"><a v-on:click="getBloque(cont,cve.clase[cont],nombre.clase[cont])">@{{nombre.bloque[cont]}}</a></li>
                                </ol>
                                <span v-if="formErrors['gtin.'+cont]" class="error text-danger">
                                    @{{ formErrors['gtin.'+cont] }}
                                </span>

                                <div class="list-group" v-if="newItem.gtin[cont] == ''">
                                    <div v-if="posicion_identificador_comercial[cont] == 1">
                                        <label for="formula">Segmento:</label>
                                        <div class="row">
                                            <div class="col-md-1 col-sm-1"></div>
                                            <div class="col-md-10 col-sm-10">
                                                <a v-for="segmento in productos_segmento[cont]" v-on:click="getFamilia(cont,segmento.cve_segmento,segmento.nombre_segmento)" class="list-group-item">
                                                    @{{ segmento.nombre_segmento }}
                                                </a>
                                            </div>
                                            <div class="col-md-1 col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div v-if="posicion_identificador_comercial[cont] == 2">
                                        <label for="formula">Familia:</label>
                                        <div class="row">
                                            <div class="col-md-1 col-sm-1"></div>
                                            <div class="col-md-10 col-sm-10">
                                                <a v-for="familia in productos_familia[cont]" v-on:click="getClase(cont,familia.cve_familia,familia.nombre_familia)" class="list-group-item">
                                                    @{{ familia.nombre_familia }}
                                                </a>
                                            </div>
                                            <div class="col-md-1 col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div v-if="posicion_identificador_comercial[cont] == 3">
                                        <label for="formula">Clase:</label>
                                        <div class="row">
                                            <div class="col-md-1 col-sm-1"></div>
                                            <div class="col-md-10 col-sm-10">
                                                <a v-for="clase in productos_clase[cont]" v-on:click="getBloque(cont,clase.cve_clase,clase.nombre_clase)" class="list-group-item">
                                                    @{{ clase.nombre_clase }}
                                                </a>
                                            </div>
                                            <div class="col-md-1 col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div v-if="posicion_identificador_comercial[cont] == 4">
                                        <label for="formula">Bloque:</label>
                                        <div class="row">
                                            <div class="col-md-1 col-sm-1"></div>
                                            <div class="col-md-10 col-sm-10">
                                                <a v-for="bloque in productos_bloque[cont]" v-on:click="getAll(cont,bloque.cve_bloque,bloque.nombre_bloque)" class="list-group-item">
                                                    @{{ bloque.nombre_bloque }}
                                                </a>
                                            </div>
                                            <div class="col-md-1 col-sm-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precio_unitario">precio_unitario:</label>
                                    <input type="text" class="form-control"  v-model="newItem.precio_unitario[cont]" autocomplete="off">
                                    <span v-if="formErrors['precio_unitario.'+cont]" class="error text-danger">
                                        @{{ formErrors['precio_unitario.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="piezas_por_paquete">piezas_por_paquete:</label>
                                    <input type="text" class="form-control"  v-model="newItem.piezas_por_paquete[cont]" autocomplete="off">
                                    <span v-if="formErrors['piezas_por_paquete.'+cont]" class="error text-danger">
                                        @{{ formErrors['piezas_por_paquete.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="venta_minima">venta_minima:</label>
                                    <input type="text" class="form-control"  v-model="newItem.venta_minima[cont]" autocomplete="off">
                                    <span v-if="formErrors['venta_minima.'+cont]" class="error text-danger">
                                        @{{ formErrors['venta_minima.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="peso_unitario">peso_unitario:</label>
                                    <input type="text" class="form-control"  v-model="newItem.peso_unitario[cont]" autocomplete="off">
                                    <span v-if="formErrors['peso_unitario.'+cont]" class="error text-danger">
                                        @{{ formErrors['peso_unitario.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label>
                                            <input type="checkbox" v-model="newItem.es_venta[cont]" v-bind:true-value="1" v-bind:false-value="0" value="0"> es_venta
                                        </label>
                                    </div>
                                    <span v-if="formErrors['es_venta.'+cont]" class="error text-danger">
                                        @{{ formErrors['es_venta.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label>
                                            <input type="checkbox" v-model="newItem.considerar_margen[cont]" v-bind:true-value="1" v-bind:false-value="0" value="0"> considerar_margen
                                        </label>
                                    </div>
                                    <span v-if="formErrors['considerar_margen.'+cont]" class="error text-danger">
                                        @{{ formErrors['considerar_margen.'+cont] }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="cve_unidad_medida">cve_unidad_medida:</label>
                                    <v-select :options="unidad_medida" v-model="newItem.cve_unidad_medida[cont]" placeholder="Seleccione..."   >
                                    </v-select>
                                    <span v-if="formErrors['cve_unidad_medida.'+cont]" class="error text-danger">
                                        @{{ formErrors['cve_unidad_medida.'+cont] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 col-sm-2"></div>
                            <div class="col-md-8 col-sm-8">
                                <button type="button" v-on:click="addContador()" class="btn btn-warning btn-sm btn-block">
                                    <i class="fa fa-plus-square-o fa-lg text-center" aria-hidden="true"></i> Agregar GTIN
                                </button>
                            </div>
                            <div class="col-md-2 col-sm-2"></div>
                        </div>

                        <br>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@stop

@section('javascript')
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script type="text/javascript" src="{{ asset('vue-1.0.28/vue-resource.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inv_cat_productos.js') }}"></script>


@stop
