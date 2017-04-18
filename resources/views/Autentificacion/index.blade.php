@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar usuarios</h1>
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
                        <th>Cve usuario</th>
                        <th>Nombre</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.Cve_usuario }}</td>
                        <td>@{{ item.Nombre }}</td>
                        <td>
                            <button class="edit-modal btn btn-warning btn-sm" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                            <button class="edit-modal btn btn-danger btn-sm" @click.prevent="deleteItem(item)">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                            <a href="{{ URL::to('/').'/administracion/syscat_usuariostransacciones/'}}@{{ item.Cve_usuario }}" class="btn btn-default btn-sm"><i class="fa fa-exchange" aria-hidden="true"></i> Transacciones</a>
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
                        <label for="Cve_usuario">Correo:</label>
                        <input type="text" name="Cve_usuario" class="form-control" v-model="newItem.Cve_usuario" />
                        <span v-if="formErrors['Cve_usuario']" class="error text-danger">
                            @{{ formErrors['Cve_usuario'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Nombre">Nombre:</label>
                        <input type="text" name="Nombre" class="form-control" v-model="newItem.Nombre" />
                        <span v-if="formErrors['Nombre']" class="error text-danger">
                            @{{ formErrors['Nombre'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="text" name="Password" class="form-control" v-model="newItem.Password" />
                        <span v-if="formErrors['Password']" class="error text-danger">
                            @{{ formErrors['Password'] }}
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
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.Cve_usuario)">
                    <div class="form-group">
                        <label for="Nombre">Nombre:</label>
                        <input type="text" name="Nombre" class="form-control" v-model="fillItem.Nombre" />
                        <span v-if="formErrorsUpdate['Nombre']" class="error text-danger">
                            @{{ formErrorsUpdate['Nombre'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="text" name="Password" class="form-control"  />
                        <span v-if="formErrorsUpdate['Password']" class="error text-danger">
                            @{{ formErrorsUpdate['Password'] }}
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
<script type="text/javascript" src="{{ asset('js/autentificacion.js') }}"></script>
@stop