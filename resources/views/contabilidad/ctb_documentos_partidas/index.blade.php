@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar compañias</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Crear
            </button>
        </div>
    </div>
</div>

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

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr style="background: rgba(245,245,245,0.5);border: 0px">
                        <th>num_partida</th>
                        <th>id_conceptofinanciero</th>
                        <th>descripcion_complementaria</th>
                        <th>cantidad</th>
                        <th>cve_unidad_medida</th>

                        <th>precio_unitario</th>
                        <th>porcentaje_impuesto</th>
                        <th>porcentaje_descuento</th>
                        <th>subtotal</th>
                        <th>total_partida</th>
                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.num_partida }}</td>
                        <td>@{{ item.id_conceptofinanciero }}</td>
                        <td>@{{ item.descripcion_complementaria }}</td>
                        <td>@{{ item.cantidad }}</td>
                        <td>@{{ item.cve_unidad_medida }}</td>
                        <td>@{{ item.precio_unitario }}</td>
                        <td>@{{ item.porcentaje_impuesto }}</td>
                        <td>@{{ item.porcentaje_descuento }}</td>
                        <td>@{{ item.subtotal }}</td>
                        <td>@{{ item.total_partida }}</td>
                        <td>
                            <button class="edit-modal btn btn-warning btn-sm" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
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


<!-- Create Item Modal -->
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create New Post</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                    <div class="form-group">
                        <label for="folio_documento">folio_documento:</label>
                        <input type="text" name="folio_documento" class="form-control" v-model="newItem.folio_documento" />
                        <span v-if="formErrors['folio_documento']" class="error text-danger">
                            @{{ formErrors['folio_documento'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_partida">num_partida:</label>
                        <input type="text" name="num_partida" class="form-control" v-model="newItem.num_partida" />
                        <span v-if="formErrors['num_partida']" class="error text-danger">
                            @{{ formErrors['num_partida'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="id_conceptofinanciero">id_conceptofinanciero:</label>
                        <input type="text" name="id_conceptofinanciero" class="form-control" v-model="newItem.id_conceptofinanciero" />
                        <span v-if="formErrors['id_conceptofinanciero']" class="error text-danger">
                            @{{ formErrors['id_conceptofinanciero'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="descripcion_complementaria">descripcion_complementaria:</label>
                        <input type="text" name="descripcion_complementaria" class="form-control" v-model="newItem.descripcion_complementaria" />
                        <span v-if="formErrors['descripcion_complementaria']" class="error text-danger">
                            @{{ formErrors['descripcion_complementaria'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">cantidad:</label>
                        <input type="text" name="cantidad" class="form-control" v-model="newItem.cantidad" />
                        <span v-if="formErrors['cantidad']" class="error text-danger">
                            @{{ formErrors['cantidad'] }}
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="cve_unidad_medida">cve_unidad_medida:</label>
                        <input type="text" name="cve_unidad_medida" class="form-control" v-model="newItem.cve_unidad_medida" />
                        <span v-if="formErrors['cve_unidad_medida']" class="error text-danger">
                            @{{ formErrors['cve_unidad_medida'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="precio_unitario">precio_unitario:</label>
                        <input type="text" name="precio_unitario" class="form-control" v-model="newItem.precio_unitario" />
                        <span v-if="formErrors['precio_unitario']" class="error text-danger">
                            @{{ formErrors['precio_unitario'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="porcentaje_impuesto">porcentaje_impuesto:</label>
                        <input type="text" name="porcentaje_impuesto" class="form-control" v-model="newItem.porcentaje_impuesto" />
                        <span v-if="formErrors['porcentaje_impuesto']" class="error text-danger">
                            @{{ formErrors['porcentaje_impuesto'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="porcentaje_descuento">porcentaje_descuento:</label>
                        <input type="text" name="porcentaje_descuento" class="form-control" v-model="newItem.porcentaje_descuento" />
                        <span v-if="formErrors['porcentaje_descuento']" class="error text-danger">
                            @{{ formErrors['porcentaje_descuento'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="subtotal">subtotal:</label>
                        <input type="text" name="subtotal" class="form-control" v-model="newItem.subtotal" />
                        <span v-if="formErrors['subtotal']" class="error text-danger">
                            @{{ formErrors['subtotal'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="total_partida">total_partida:</label>
                        <input type="text" name="total_partida" class="form-control" v-model="newItem.total_partida" />
                        <span v-if="formErrors['total_partida']" class="error text-danger">
                            @{{ formErrors['total_partida'] }}
                        </span>
                    </div>
                    
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Item Modal -->
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Editar usuario</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.cve_compania)">
                    <div class="form-group">
                        <label for="folio_documento">folio_documento:</label>
                        <input type="text" name="folio_documento" class="form-control" v-model="fillItem.folio_documento" />
                        <span v-if="formErrors['folio_documento']" class="error text-danger">
                            @{{ formErrors['folio_documento'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_partida">num_partida:</label>
                        <input type="text" name="num_partida" class="form-control" v-model="fillItem.num_partida" />
                        <span v-if="formErrors['num_partida']" class="error text-danger">
                            @{{ formErrors['num_partida'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="id_conceptofinanciero">id_conceptofinanciero:</label>
                        <input type="text" name="id_conceptofinanciero" class="form-control" v-model="fillItem.id_conceptofinanciero" />
                        <span v-if="formErrors['id_conceptofinanciero']" class="error text-danger">
                            @{{ formErrors['id_conceptofinanciero'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_complementaria">descripcion_complementaria:</label>
                        <input type="text" name="descripcion_complementaria" class="form-control" v-model="fillItem.descripcion_complementaria" />
                        <span v-if="formErrors['descripcion_complementaria']" class="error text-danger">
                            @{{ formErrors['descripcion_complementaria'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">cantidad:</label>
                        <input type="text" name="cantidad" class="form-control" v-model="fillItem.cantidad" />
                        <span v-if="formErrors['cantidad']" class="error text-danger">
                            @{{ formErrors['cantidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_unidad_medida">cve_unidad_medida:</label>
                        <input type="text" name="cve_unidad_medida" class="form-control" v-model="fillItem.cve_unidad_medida" />
                        <span v-if="formErrors['cve_unidad_medida']" class="error text-danger">
                            @{{ formErrors['cve_unidad_medida'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="precio_unitario">precio_unitario:</label>
                        <input type="text" name="precio_unitario" class="form-control" v-model="fillItem.precio_unitario" />
                        <span v-if="formErrors['precio_unitario']" class="error text-danger">
                            @{{ formErrors['precio_unitario'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="porcentaje_impuesto">porcentaje_impuesto:</label>
                        <input type="text" name="porcentaje_impuesto" class="form-control" v-model="fillItem.porcentaje_impuesto" />
                        <span v-if="formErrors['porcentaje_impuesto']" class="error text-danger">
                            @{{ formErrors['porcentaje_impuesto'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="porcentaje_descuento">porcentaje_descuento:</label>
                        <input type="text" name="porcentaje_descuento" class="form-control" v-model="fillItem.porcentaje_descuento" />
                        <span v-if="formErrors['porcentaje_descuento']" class="error text-danger">
                            @{{ formErrors['porcentaje_descuento'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="subtotal">subtotal:</label>
                        <input type="text" name="subtotal" class="form-control" v-model="fillItem.subtotal" />
                        <span v-if="formErrors['subtotal']" class="error text-danger">
                            @{{ formErrors['subtotal'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="total_partida">total_partida:</label>
                        <input type="text" name="total_partida" class="form-control" v-model="fillItem.total_partida" />
                        <span v-if="formErrors['total_partida']" class="error text-danger">
                            @{{ formErrors['total_partida'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/ctb_documentos_partidas.js') }}"></script>
@stop