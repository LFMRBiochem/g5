@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar ctb_cat_monedas</h1>
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
                        <th>cve_moneda</th>
                        <th>nombre_moneda</th>
                        <th>simbolo</th>
                        <th>posicion</th>
                        <th>numero_decimales</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.cve_moneda }}</td>
                        <td>@{{ item.nombre_moneda }}</td>
                        <td>@{{ item.simbolo }}</td>
                        <td>@{{ item.posicion }}</td>
                        <td>@{{ item.numero_decimales }}</td>
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
                        <label for="cve_moneda">cve_moneda:</label>
                        <input type="text" name="cve_moneda" class="form-control" v-model="newItem.cve_moneda" />
                        <span v-if="formErrors['cve_moneda']" class="error text-danger">
                            @{{ formErrors['cve_moneda'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="nombre_moneda">nombre_moneda:</label>
                        <input type="text" name="nombre_moneda" class="form-control" v-model="newItem.nombre_moneda" />
                        <span v-if="formErrors['nombre_moneda']" class="error text-danger">
                            @{{ formErrors['nombre_moneda'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="simbolo">simbolo:</label>
                        <input type="text" name="simbolo" class="form-control" v-model="newItem.simbolo" />
                        <span v-if="formErrors['simbolo']" class="error text-danger">
                            @{{ formErrors['simbolo'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="posicion">posicion:</label>
                        <input type="text" name="posicion" class="form-control" v-model="newItem.posicion" />
                        <span v-if="formErrors['posicion']" class="error text-danger">
                            @{{ formErrors['posicion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="numero_decimales">numero_decimales:</label>
                        <input type="text" name="numero_decimales" class="form-control" v-model="newItem.numero_decimales" />
                        <span v-if="formErrors['numero_decimales']" class="error text-danger">
                            @{{ formErrors['numero_decimales'] }}
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
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.cve_moneda)">
                    <div class="form-group">
                        <label for="cve_moneda">cve_moneda:</label>
                        <input type="text" name="cve_moneda" class="form-control" v-model="fillItem.cve_moneda" />
                        <span v-if="formErrors['cve_moneda']" class="error text-danger">
                            @{{ formErrors['cve_moneda'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="nombre_moneda">nombre_moneda:</label>
                        <input type="text" name="nombre_moneda" class="form-control" v-model="fillItem.nombre_moneda" />
                        <span v-if="formErrors['nombre_moneda']" class="error text-danger">
                            @{{ formErrors['nombre_moneda'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="simbolo">simbolo:</label>
                        <input type="text" name="simbolo" class="form-control" v-model="fillItem.simbolo" />
                        <span v-if="formErrors['simbolo']" class="error text-danger">
                            @{{ formErrors['simbolo'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="posicion">posicion:</label>
                        <input type="text" name="posicion" class="form-control" v-model="fillItem.posicion" />
                        <span v-if="formErrors['posicion']" class="error text-danger">
                            @{{ formErrors['posicion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="numero_decimales">numero_decimales:</label>
                        <input type="text" name="numero_decimales" class="form-control" v-model="fillItem.numero_decimales" />
                        <span v-if="formErrors['numero_decimales']" class="error text-danger">
                            @{{ formErrors['numero_decimales'] }}
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
<script type="text/javascript" src="{{ asset('js/ctb_cat_monedas.js') }}"></script>
@stop