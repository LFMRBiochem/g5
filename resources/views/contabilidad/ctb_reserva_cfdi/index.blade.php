@extends('layout.app')
@section('content')
<div class="form-group row add">
    <div class="page-header">
        <h1>Listar ctb_reserva_cfdi</h1>
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
                        <th>cve_compania</th>
                        <th>UUID</th>
                        <th>rfc</th>

                        <th>total</th>
                        <th>nombre_proveedor</th>
                        <th>folio</th>
                        <th>subtotal</th>
                        <th>descuento</th>

                        <th>metodo_pago</th>
                        <th>cve_moneda</th>
                        <th>error_suma</th>
                        <th>descripcion</th>
                        <th>asociado</th>

                        <th>Actions</th>
                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.cve_compania }}</td>
                        <td>@{{ item.UUID }}</td>
                        <td>@{{ item.rfc }}</td>

                        <td>@{{ item.total }}</td>
                        <td>@{{ item.nombre_proveedor }}</td>
                        <td>@{{ item.folio }}</td>
                        <td>@{{ item.subtotal }}</td>
                        <td>@{{ item.descuento }}</td>

                        <td>@{{ item.metodo_pago }}</td>
                        <td>@{{ item.cve_moneda }}</td>
                        <td>@{{ item.error_suma }}</td>
                        <td>@{{ item.descripcion }}</td>
                        <td>@{{ item.asociado }}</td>
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

                        <label for="cve_compania">cve_compania:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="newItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="UUID">UUID:</label>
                        <input type="text" name="UUID" class="form-control" v-model="newItem.UUID" />
                        <span v-if="formErrors['UUID']" class="error text-danger">
                            @{{ formErrors['UUID'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="rfc">rfc:</label>
                        <input type="text" name="rfc" class="form-control" v-model="newItem.rfc" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="total">total:</label>
                        <input type="text" name="total" class="form-control" v-model="newItem.total" />
                        <span v-if="formErrors['total']" class="error text-danger">
                            @{{ formErrors['total'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nombre_proveedor">nombre_proveedor:</label>
                        <input type="text" name="nombre_proveedor" class="form-control" v-model="newItem.nombre_proveedor" />
                        <span v-if="formErrors['nombre_proveedor']" class="error text-danger">
                            @{{ formErrors['nombre_proveedor'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="folio">folio:</label>
                        <input type="text" name="folio" class="form-control" v-model="newItem.folio" />
                        <span v-if="formErrors['folio']" class="error text-danger">
                            @{{ formErrors['folio'] }}
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
                        <label for="descuento">descuento:</label>
                        <input type="text" name="descuento" class="form-control" v-model="newItem.descuento" />
                        <span v-if="formErrors['descuento']" class="error text-danger">
                            @{{ formErrors['descuento'] }}
                        </span>
                    </div>

                    <!------------------------>
                    <div class="form-group">
                        <label for="metodo_pago">metodo_pago:</label>
                        <input type="text" name="metodo_pago" class="form-control" v-model="newItem.metodo_pago" />
                        <span v-if="formErrors['metodo_pago']" class="error text-danger">
                            @{{ formErrors['metodo_pago'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_moneda">cve_moneda:</label>
                        <input type="text" name="cve_moneda" class="form-control" v-model="newItem.cve_moneda" />
                        <span v-if="formErrors['cve_moneda']" class="error text-danger">
                            @{{ formErrors['cve_moneda'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="error_suma">error_suma:</label>
                        <input type="text" name="error_suma" class="form-control" v-model="newItem.error_suma" />
                        <span v-if="formErrors['error_suma']" class="error text-danger">
                            @{{ formErrors['error_suma'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">descripcion:</label>
                        <input type="text" name="descripcion" class="form-control" v-model="newItem.descripcion" />
                        <span v-if="formErrors['descripcion']" class="error text-danger">
                            @{{ formErrors['descripcion'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="asociado">asociado:</label>
                        <input type="text" name="asociado" class="form-control" v-model="newItem.asociado" />
                        <span v-if="formErrors['asociado']" class="error text-danger">
                            @{{ formErrors['asociado'] }}
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
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id_reserva)">
                    <div class="form-group">
                        <label for="cve_compania">cve_compania:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="fillItem.cve_compania" />
                        <span v-if="formErrorsUpdate['cve_compania']" class="error text-danger">
                            @{{ formErrorsUpdate['cve_compania'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="UUID">UUID:</label>
                        <input type="text" name="UUID" class="form-control" v-model="fillItem.UUID" />
                        <span v-if="formErrorsUpdate['UUID']" class="error text-danger">
                            @{{ formErrorsUpdate['UUID'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="rfc">rfc:</label>
                        <input type="text" name="rfc" class="form-control" v-model="fillItem.rfc" />
                        <span v-if="formErrorsUpdate['rfc']" class="error text-danger">
                            @{{ formErrorsUpdate['rfc'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="total">total:</label>
                        <input type="text" name="total" class="form-control" v-model="fillItem.total" />
                        <span v-if="formErrorsUpdate['total']" class="error text-danger">
                            @{{ formErrorsUpdate['total'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nombre_proveedor">nombre_proveedor:</label>
                        <input type="text" name="nombre_proveedor" class="form-control" v-model="fillItem.nombre_proveedor" />
                        <span v-if="formErrorsUpdate['nombre_proveedor']" class="error text-danger">
                            @{{ formErrorsUpdate['nombre_proveedor'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="folio">folio:</label>
                        <input type="text" name="folio" class="form-control" v-model="fillItem.folio" />
                        <span v-if="formErrorsUpdate['folio']" class="error text-danger">
                            @{{ formErrorsUpdate['folio'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="subtotal">subtotal:</label>
                        <input type="text" name="subtotal" class="form-control" v-model="fillItem.subtotal" />
                        <span v-if="formErrorsUpdate['subtotal']" class="error text-danger">
                            @{{ formErrorsUpdate['subtotal'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="descuento">descuento:</label>
                        <input type="text" name="descuento" class="form-control" v-model="fillItem.descuento" />
                        <span v-if="formErrorsUpdate['descuento']" class="error text-danger">
                            @{{ formErrorsUpdate['descuento'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="metodo_pago">metodo_pago:</label>
                        <input type="text" name="metodo_pago" class="form-control" v-model="fillItem.metodo_pago" />
                        <span v-if="formErrorsUpdate['metodo_pago']" class="error text-danger">
                            @{{ formErrorsUpdate['metodo_pago'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_moneda">cve_moneda:</label>
                        <input type="text" name="cve_moneda" class="form-control" v-model="fillItem.cve_moneda" />
                        <span v-if="formErrorsUpdate['cve_moneda']" class="error text-danger">
                            @{{ formErrorsUpdate['cve_moneda'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="error_suma">error_suma:</label>
                        <input type="text" name="error_suma" class="form-control" v-model="fillItem.error_suma" />
                        <span v-if="formErrorsUpdate['error_suma']" class="error text-danger">
                            @{{ formErrorsUpdate['error_suma'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">descripcion:</label>
                        <input type="text" name="descripcion" class="form-control" v-model="fillItem.descripcion" />
                        <span v-if="formErrorsUpdate['descripcion']" class="error text-danger">
                            @{{ formErrorsUpdate['descripcion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="asociado">asociado:</label>
                        <input type="text" name="asociado" class="form-control" v-model="fillItem.asociado" />
                        <span v-if="formErrorsUpdate['asociado']" class="error text-danger">
                            @{{ formErrorsUpdate['asociado'] }}
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
<script type="text/javascript" src="{{ asset('js/ctb_reserva_cfdi.js') }}"></script>
@stop