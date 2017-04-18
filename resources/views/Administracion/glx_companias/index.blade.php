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
                        <th>cve_compania</th>
                        <th>razon_social</th>
                        <th>nombre_corto</th>
                        <th>rfc</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.cve_compania }}</td>
                        <td>@{{ item.razon_social }}</td>
                         <td>@{{ item.nombre_corto }}</td>
                        <td>@{{ item.rfc }}</td>
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
                        <label for="razon_social">razon_social:</label>
                        <input type="text" name="razon_social" class="form-control" v-model="newItem.razon_social" />
                        <span v-if="formErrors['razon_social']" class="error text-danger">
                            @{{ formErrors['razon_social'] }}
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="nombre_corto">nombre_corto:</label>
                        <input type="text" name="nombre_corto" class="form-control" v-model="newItem.nombre_corto" />
                        <span v-if="formErrors['nombre_corto']" class="error text-danger">
                            @{{ formErrors['nombre_corto'] }}
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
                        <label for="razon_social">razon_social:</label>
                        <input type="text" name="razon_social" class="form-control" v-model="fillItem.razon_social" />
                        <span v-if="formErrorsUpdate['razon_social']" class="error text-danger">
                            @{{ formErrorsUpdate['razon_social'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nombre_corto">nombre_corto:</label>
                        <input type="text" name="nombre_corto" class="form-control" v-model="fillItem.nombre_corto" />
                        <span v-if="formErrorsUpdate['nombre_corto']" class="error text-danger">
                            @{{ formErrorsUpdate['nombre_corto'] }}
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
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/glx_companias.js') }}"></script>
@stop